<template>
  <div class="home-view">
    <!-- Store Errors Display -->
    <div v-if="hasStoreErrors" class="error-banner">
      <h3>⚠️ Store Connection Issues</h3>
      <div v-for="(error, key) in productStore.errors" :key="key">
        <p v-if="error">
          <strong>{{ key }}:</strong> {{ error }}
        </p>
      </div>
    </div>

    <!-- Loading State -->
    <div v-if="loading" class="loading-state">
      <div class="loading-spinner"></div>
      <p>Loading e-commerce data...</p>
    </div>

    <div v-else>
      <!-- Featured Categories Section -->
      <section class="featured-categories">
        <div class="section-header">
          <h2>Featured Categories</h2>
          <div class="filter-tabs">
            <button
              v-for="tab in categoryTabs"
              :key="tab.id"
              class="filter-tab"
              :class="{ active: activeFilter === tab.id }"
              @click="activeFilter = tab.id"
            >
              {{ tab.name }}
            </button>
          </div>
        </div>
        <div class="categories-grid">
          <div v-for="category in displayedCategories" :key="category.id" class="category-card">
            <div class="category-image">
              <img :src="category.image" :alt="category.name" />
            </div>
            <div class="category-info">
              <h3>{{ category.name }}</h3>
              <p>{{ category.description }}</p>
            </div>
          </div>
        </div>
      </section>

      <!-- Popular Products Section -->
      <section class="popular-products">
        <div class="section-header">
          <h2>Popular Products</h2>
          <div class="filter-tabs">
            <button
              v-for="tab in productTabs"
              :key="tab.id"
              class="filter-tab"
              :class="{ active: activeProductFilter === tab.id }"
              @click="activeProductFilter = tab.id"
            >
              {{ tab.name }}
            </button>
          </div>
        </div>
        <div class="products-grid">
          <ProductComponent
            v-for="product in displayedProducts"
            :key="product.id"
            :product="product"
            @add-to-cart="addToCart"
          />
        </div>
      </section>

      <!-- Promotional Banners Section -->
      <section class="promotional-banners">
        <div class="section-header">
          <h2>Special Offers</h2>
        </div>
        <div class="promotions-grid">
          <div v-for="promotion in promotions" :key="promotion.id" class="promotion-card">
            <div class="promotion-content">
              <h3>{{ promotion.title }}</h3>
              <p>{{ promotion.description }}</p>
              <div class="promotion-details">
                <span class="discount">{{ promotion.discountValue }}% OFF</span>
                <button class="cta-button">Shop Now</button>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>

<script>
import { useProductStore } from '../stores/productStore'
import ProductComponent from '../components/ProductComponent.vue'
import ButtonComponent from '../components/ButtonComponent.vue'
import StoreDemo from '../components/StoreDemo.vue'
import MultiGetter from '../components/MultiGetter.vue'
import axios from 'axios'

export default {
  name: 'HomeView',
  components: {
    ButtonComponent,
    StoreDemo,
    MultiGetter,
    ProductComponent,
  },
  data() {
    return {
      categories: [],
      promotions: [],
      loading: true,
      showDemoComponents: false,
      activeFilter: 'all',
      activeProductFilter: 'all',
      cart: [],
    }
  },
  setup() {
    const productStore = useProductStore()
    return {
      productStore,
    }
  },
  computed: {
    hasStoreErrors() {
      return (
        this.productStore?.errors &&
        Object.keys(this.productStore.errors).some((key) => this.productStore.errors[key])
      )
    },

    categoryTabs() {
      return [
        { id: 'all', name: 'All' },
        { id: 'milk', name: 'Milk & Dairies' },
        { id: 'coffee', name: 'Coffee & Teas' },
        { id: 'pet', name: 'Pet Food' },
        { id: 'meats', name: 'Meats' },
        { id: 'vegetables', name: 'Vegetables' },
        { id: 'fruits', name: 'Fruits' },
      ]
    },

    productTabs() {
      return [
        { id: 'all', name: 'All' },
        { id: 'milk', name: 'Milks & Dairies' },
        { id: 'coffee', name: 'Coffee & Teas' },
        { id: 'pet', name: 'Pet Foods' },
        { id: 'meats', name: 'Meats' },
        { id: 'vegetables', name: 'Vegetables' },
        { id: 'fruits', name: 'Fruits' },
      ]
    },

    displayedCategories() {
      if (this.activeFilter === 'all') {
        return this.categories.slice(0, 10) // Show first 10 categories
      }
      // Filter categories based on activeFilter if needed
      return this.categories.slice(0, 10)
    },

    displayedProducts() {
      // Force reactivity check
      const products = this.productStore?.products || []

      console.log('🔍 Computing displayedProducts...')
      console.log('   - Products available:', products.length)
      console.log('   - Loading state:', this.loading)
      console.log('   - Active filter:', this.activeProductFilter)

      // Check for duplicate IDs
      if (products.length > 0) {
        const ids = products.map((p) => p.id)
        const uniqueIds = [...new Set(ids)]
        if (ids.length !== uniqueIds.length) {
          console.error('🚨 DUPLICATE PRODUCTS DETECTED!')
          console.error('   - Total products:', ids.length)
          console.error('   - Unique IDs:', uniqueIds.length)
          console.error(
            '   - Duplicate IDs:',
            ids.filter((id, index) => ids.indexOf(id) !== index),
          )
        }
      }

      // If no products, return empty array
      if (products.length === 0) {
        console.log('   - No products in store, returning empty array')
        return []
      }

      // For "All" filter, return first 10 products
      if (this.activeProductFilter === 'all') {
        const result = products.slice(0, 10)
        console.log('   - Returning all products:', result.length)
        return result
      }

      // For other filters, filter by group and return first 10
      const filtered = this.productStore.getProductsByGroup(this.activeProductFilter)
      const result = filtered.slice(0, 10)
      console.log(
        '   - Returning filtered products:',
        result.length,
        'for group:',
        this.activeProductFilter,
      )
      return result
    },
  },
  watch: {
    'productStore.products': {
      handler(newProducts) {
        console.log('🔔 Products changed in store:', newProducts ? newProducts.length : 'null')
        if (newProducts && newProducts.length > 0) {
          console.log('   - First product:', newProducts[0].name)
        }
      },
      immediate: true,
    },
  },
  methods: {
    async testAPIConnectivity() {
      this.apiTestResult = {}
      const endpoints = ['products', 'categories', 'groups', 'promotions']

      console.log('🧪 Testing API connectivity...')

      for (const endpoint of endpoints) {
        try {
          console.log(`Testing /api/${endpoint}...`)
          const response = await axios.get(`/api/${endpoint}`, { timeout: 5000 })
          this.apiTestResult[endpoint] = {
            success: true,
            status: response.status,
            dataLength: response.data?.length || 0,
          }
          console.log(`✅ ${endpoint}: OK (${response.status})`)
        } catch (error) {
          this.apiTestResult[endpoint] = {
            success: false,
            error: error.message,
          }
          console.log(`❌ ${endpoint}: FAILED - ${error.message}`)
        }
      }

      console.log('🎯 API Test Results:', this.apiTestResult)
    },

    async loadLocalData() {
      try {
        // Load categories from store
        this.categories = this.productStore.categories || []
        this.promotions = this.productStore.promotions || []

        console.log('📦 Loaded local data:')
        console.log('   - Categories:', this.categories.length)
        console.log('   - Promotions:', this.promotions.length)
      } catch (error) {
        console.error('❌ Error loading local data:', error)
      }
    },

    addToCart(product) {
      console.log('🛒 Adding to cart:', product.name)
      this.cart.push({
        ...product,
        quantity: 1,
        addedAt: new Date(),
      })

      // Show success message
      if (window.Swal) {
        Swal.fire({
          title: 'Added to Cart!',
          text: `${product.name} has been added to your cart.`,
          icon: 'success',
          timer: 2000,
          showConfirmButton: false,
        })
      } else {
        alert(`${product.name} added to cart!`)
      }
    },

    toggleDemoComponents() {
      this.showDemoComponents = !this.showDemoComponents
      console.log('🎛️ Demo components visibility:', this.showDemoComponents)
    },
  },

  async mounted() {
    console.log('🚀 HomeView mounted, starting data load...')

    try {
      // Load all data from the product store
      await this.productStore.loadAllData()

      // Load local categories and promotions
      await this.loadLocalData()

      console.log('✅ All data loaded successfully')
    } catch (error) {
      console.error('❌ Error during data loading:', error)
    } finally {
      this.loading = false
      console.log('🎯 HomeView loading complete')
    }
  },
}
</script>

<style scoped>
/* Home View Styles */
.home-view {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
  background-color: #f8f9fa;
  min-height: 100vh;
  overflow-y: auto;
}

/* Error Banner */
.error-banner {
  background-color: #fff3cd;
  border: 1px solid #ffeaa7;
  border-radius: 8px;
  padding: 15px;
  margin-bottom: 20px;
  color: #856404;
}

.error-banner h3 {
  margin: 0 0 10px 0;
  color: #721c24;
}

.error-banner p {
  margin: 5px 0;
  font-size: 14px;
}

/* Loading State */
.loading-state {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  min-height: 200px;
  color: #666;
}

.loading-spinner {
  border: 4px solid #f3f3f3;
  border-top: 4px solid #3498db;
  border-radius: 50%;
  width: 40px;
  height: 40px;
  animation: spin 1s linear infinite;
  margin-bottom: 15px;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

/* Section Headers */
.section-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
  padding-bottom: 10px;
  border-bottom: 2px solid #e9ecef;
}

.section-header h2 {
  color: #2c3e50;
  font-size: 28px;
  font-weight: 600;
  margin: 0;
}

/* Filter Tabs */
.filter-tabs {
  display: flex;
  gap: 10px;
}

.filter-tab {
  padding: 8px 16px;
  border: 2px solid #e9ecef;
  background: white;
  color: #6c757d;
  border-radius: 20px;
  cursor: pointer;
  transition: all 0.3s ease;
  font-weight: 500;
}

.filter-tab:hover {
  border-color: #3498db;
  color: #3498db;
}

.filter-tab.active {
  background-color: #3498db;
  border-color: #3498db;
  color: white;
}

/* Categories Grid */
.categories-grid {
  display: grid;
  grid-template-columns: repeat(10, 1fr);
  gap: 15px;
  margin-bottom: 40px;
}

.category-card {
  background: white;
  border-radius: 12px;
  padding: 15px;
  text-align: center;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  transition:
    transform 0.3s ease,
    box-shadow 0.3s ease;
  cursor: pointer;
  background-color: #f8f9fa;
}

.category-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
}

.category-image {
  width: 50px;
  height: 50px;
  margin: 0 auto 10px;
  border-radius: 8px;
  overflow: hidden;
}

.category-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.category-info h3 {
  font-size: 14px;
  font-weight: 600;
  color: #2c3e50;
  margin: 0 0 5px 0;
}

.category-info p {
  font-size: 12px;
  color: #6c757d;
  margin: 0;
  line-height: 1.3;
}

/* Products Grid */
.products-grid {
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  gap: 20px;
  margin-bottom: 40px;
}

/* Promotions Grid */
.promotions-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 20px;
}

.promotion-card {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border-radius: 12px;
  padding: 25px;
  color: white;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease;
}

.promotion-card:hover {
  transform: translateY(-3px);
}

.promotion-content h3 {
  font-size: 20px;
  font-weight: 600;
  margin: 0 0 10px 0;
}

.promotion-content p {
  font-size: 14px;
  opacity: 0.9;
  margin: 0 0 15px 0;
  line-height: 1.4;
}

.promotion-details {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.discount {
  font-size: 18px;
  font-weight: 700;
  background: rgba(255, 255, 255, 0.2);
  padding: 5px 12px;
  border-radius: 20px;
}

.cta-button {
  background: white;
  color: #667eea;
  border: none;
  padding: 10px 20px;
  border-radius: 6px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
}

.cta-button:hover {
  background: #f8f9fa;
  transform: translateY(-1px);
}

/* Responsive Design */
@media (max-width: 1024px) {
  .categories-grid {
    grid-template-columns: repeat(8, 1fr);
  }

  .products-grid {
    grid-template-columns: repeat(4, 1fr);
  }
}

@media (max-width: 768px) {
  .section-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 15px;
  }

  .categories-grid {
    grid-template-columns: repeat(4, 1fr);
  }

  .products-grid {
    grid-template-columns: repeat(2, 1fr);
  }

  .filter-tabs {
    flex-wrap: wrap;
  }
}

@media (max-width: 480px) {
  .home-view {
    padding: 15px;
  }

  .categories-grid {
    grid-template-columns: repeat(2, 1fr);
  }

  .products-grid {
    grid-template-columns: 1fr;
  }
}
</style>
