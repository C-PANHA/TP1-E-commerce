<template>
  <div class="app">
    <!-- Loading State -->
    <div v-if="loading" class="loading">
      <div class="spinner"></div>
      <p>Loading products...</p>
    </div>

    <!-- Main E-commerce Content -->
    <div v-else class="main-content">
      <!-- Featured Categories Section -->
      <section class="featured-categories">
        <div class="section-header">
          <h2>Featured Categories</h2>
          <div class="category-filters">
            <button
              v-for="tab in categoryTabs"
              :key="tab.id"
              :class="['filter-btn', { active: activeFilter === tab.id }]"
              @click="setActiveFilter(tab.id)"
            >
              {{ tab.name }}
            </button>
          </div>
        </div>

        <div class="categories-grid">
          <div
            v-for="category in displayedCategories"
            :key="category.id"
            class="category-card"
            :style="{
              background: category.bgColor || 'linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%)',
            }"
            @click="selectCategory(category)"
          >
            <div class="category-icon">
              <img
                :src="category.image"
                :alt="category.title"
                @error="handleCategoryImageError"
                loading="lazy"
              />
            </div>
            <h3>{{ category.title }}</h3>
            <p>{{ category.items }} items</p>
          </div>
        </div>
      </section>

      <!-- Promotional Banners -->
      <section class="promotional-banners">
        <div class="banners-grid">
          <PromotionComponent
            v-for="(promo, index) in promotions"
            :key="promo.id || index"
            :title="promo.title"
            :description="promo.description"
            :banner="promo.banner"
            :bgColor="promo.bgColor"
          >
            <ButtonComponent
              :label="promo.buttonText"
              color="#3bb77e"
              :title="promo.title"
              @click="shopNow(promo)"
            />
          </PromotionComponent>
        </div>
      </section>

      <!-- Popular Products Section -->
      <section class="popular-products">
        <div class="section-header">
          <h2>Popular Products</h2>
          <div class="product-filters">
            <button
              v-for="tab in productTabs"
              :key="tab.id"
              :class="['filter-btn', { active: activeProductFilter === tab.id }]"
              @click="setActiveProductFilter(tab.id)"
            >
              {{ tab.name }}
            </button>
          </div>
        </div>

        <div class="products-grid-container">
          <div v-if="displayedProducts && displayedProducts.length > 0" class="products-grid">
            <ProductComponent
              v-for="product in displayedProducts"
              :key="product.id"
              :product="product"
              @add-to-cart="handleAddToCart"
            />
          </div>

          <!-- Show message when no products -->
          <div v-else class="no-products">
            <p>{{ loading ? 'Loading products...' : 'No products available at this time.' }}</p>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>

<script>
import CategoryComponent from './components/CategoryComponent.vue'
import PromotionComponent from './components/PromotionComponent.vue'
import ButtonComponent from './components/ButtonComponent.vue'
import StoreDemo from './components/StoreDemo.vue'
import MultiGetter from './components/MultiGetter.vue'
import ProductComponent from './components/ProductComponent.vue'
import { useProductStore } from '@/stores/productStore.js'
import Swal from 'sweetalert2'
import axios from 'axios'

// Import local images
import image1 from './assets/images/categories/image1.png'
import image2 from './assets/images/categories/image2.png'
import image3 from './assets/images/categories/image3.png'
import image4 from './assets/images/categories/image4.png'
import image5 from './assets/images/categories/image5.png'
import image6 from './assets/images/categories/image6.png'
import image7 from './assets/images/categories/image7.png'
import image8 from './assets/images/categories/image8.png'
import image9 from './assets/images/categories/image9.png'
import image10 from './assets/images/categories/image10.png'

import logo1 from './assets/images/promotions/logo1.png'
import logo2 from './assets/images/promotions/logo2.png'
import logo3 from './assets/images/promotions/logo3.png'

export default {
  name: 'App',
  components: {
    CategoryComponent,
    PromotionComponent,
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

      // For specific filters
      const filterMap = {
        milk: 'Milk & Dairies',
        coffee: 'Coffee & Teas',
        pet: 'Pet Food',
        meats: 'Meats',
        vegetables: 'Vegetables',
        fruits: 'Fruits',
      }

      const groupName = filterMap[this.activeProductFilter]
      if (groupName && this.productStore.getProductsByGroup) {
        try {
          const filtered = this.productStore.getProductsByGroup(groupName)
          console.log('   - Filtered products for', groupName, ':', filtered.length)
          return filtered.slice(0, 10)
        } catch (error) {
          console.error('   - Filter error:', error)
        }
      }

      // Fallback to all products
      const fallback = products.slice(0, 10)
      console.log('   - Using fallback, returning:', fallback.length, 'products')
      return fallback
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
            code: error.code,
          }
          console.log(`❌ ${endpoint}: FAILED (${error.message})`)
        }
      }

      console.log('🧪 API connectivity test complete:', this.apiTestResult)
    },

    setActiveFilter(filterId) {
      this.activeFilter = filterId
    },

    setActiveProductFilter(filterId) {
      this.activeProductFilter = filterId
    },

    selectCategory(category) {
      console.log('Selected category:', category)
      // You can implement category navigation here
    },

    handleCategoryImageError(event) {
      // Fallback to a default image if category image fails to load
      const fallbackImages = [
        '/src/assets/images/categories/image1.png',
        '/src/assets/images/categories/image2.png',
        '/src/assets/images/categories/image3.png',
        '/src/assets/images/categories/image4.png',
        '/src/assets/images/categories/image5.png',
      ]

      const randomIndex = Math.floor(Math.random() * fallbackImages.length)
      event.target.src = fallbackImages[randomIndex]
    },

    handleAddToCart({ product, quantity }) {
      // Add to cart logic
      const existingItem = this.cart.find((item) => item.product.id === product.id)

      if (existingItem) {
        existingItem.quantity += quantity
      } else {
        this.cart.push({ product, quantity })
      }

      // Show success message
      this.showAddToCartSuccess(product, quantity)
    },

    showAddToCartSuccess(product, quantity) {
      try {
        Swal.fire({
          title: 'Added to Cart!',
          text: `${quantity}x ${product.name} has been added to your cart.`,
          icon: 'success',
          confirmButtonText: 'Continue Shopping',
          confirmButtonColor: '#3bb77e',
          timer: 3000,
          timerProgressBar: true,
          customClass: {
            popup: 'custom-swal-popup',
            title: 'custom-swal-title',
            confirmButton: 'custom-swal-confirm',
          },
        })
      } catch (error) {
        console.error('Error showing cart success dialog:', error)
        // Fallback alert if SweetAlert2 fails
        alert(`Added ${quantity}x ${product.name} to cart!`)
      }
    },

    shopNow(promotion) {
      try {
        Swal.fire({
          title: `Let's shop: ${promotion.title}`,
          icon: 'success',
          confirmButtonText: 'OK',
          confirmButtonColor: '#3bb77e',
          customClass: {
            popup: 'custom-swal-popup',
            title: 'custom-swal-title',
            confirmButton: 'custom-swal-confirm',
          },
        })
      } catch (error) {
        console.error('Error showing shop dialog:', error)
        // Fallback alert if SweetAlert2 fails
        alert(`Let's shop: ${promotion.title}`)
      }
    },

    // Load categories from API
    loadCategories() {
      return axios
        .get('/api/categories')
        .then((response) => {
          if (response.data && response.data.length > 0) {
            this.categories = response.data
            console.log('✅ Categories loaded from API:', response.data.length, 'items')
            // Debug: Show image URLs from API
            console.log('🖼️ Category image URLs from API:')
            response.data.forEach((cat, index) => {
              console.log(`   ${index + 1}. ${cat.title}: ${cat.image}`)
            })
          } else {
            console.warn('⚠️ API returned empty categories, using fallback data')
            this.loadCategoriesLocal()
          }
        })
        .catch((error) => {
          console.error('❌ Error fetching categories from API:', error)
          console.warn('🔄 Using fallback local data for categories')
          // Fallback to local data if API fails
          this.loadCategoriesLocal()
        })
    },

    // Load promotions from API
    loadPromotions() {
      return axios
        .get('/api/promotions')
        .then((response) => {
          if (response.data && response.data.length > 0) {
            this.promotions = response.data
            console.log('✅ Promotions loaded from API:', response.data.length, 'items')
          } else {
            console.warn('⚠️ API returned empty promotions, using fallback data')
            this.loadPromotionsLocal()
          }
        })
        .catch((error) => {
          console.error('❌ Error fetching promotions from API:', error)
          console.warn('🔄 Using fallback local data for promotions')
          // Fallback to local data if API fails
          this.loadPromotionsLocal()
        })
    },

    // Fallback local data for categories
    loadCategoriesLocal() {
      console.log('🏠 Loading local categories data...')
      this.categories = [
        { id: 1, title: 'Cake & Milk', items: 14, bgColor: '#FEEFEA', image: image1 },
        { id: 2, title: 'Peach', items: 17, bgColor: '#FFF3EB', image: image2 },
        { id: 3, title: 'Organic Kiwi', items: 21, bgColor: '#EAF7E9', image: image3 },
        { id: 4, title: 'Red Apple', items: 68, bgColor: '#FEEAEA', image: image4 },
        { id: 5, title: 'Snack', items: 34, bgColor: '#FFFBEA', image: image5 },
        { id: 6, title: 'Black Plum', items: 25, bgColor: '#F3EBFF', image: image6 },
        { id: 7, title: 'Vegetables', items: 65, bgColor: '#EAF7F0', image: image7 },
        { id: 8, title: 'Headphone', items: 33, bgColor: '#EBF5FF', image: image8 },
        { id: 9, title: 'Cereal', items: 40, bgColor: '#FFF5EB', image: image9 },
        { id: 10, title: 'Orange', items: 63, bgColor: '#FFF0E5', image: image10 },
      ]
    },

    // Fallback local data for promotions
    loadPromotionsLocal() {
      console.log('🏠 Loading local promotions data...')
      this.promotions = [
        {
          id: 1,
          title: 'Everyday Fresh & Clean with Our Products',
          description: 'Healthy and fresh groceries delivered to your home.',
          buttonText: 'Shop Now',
          bgColor: '#FFF3EB',
          banner: logo1,
        },
        {
          id: 2,
          title: 'Make your Breakfast Healthy and Easy',
          description: 'Start your day with milk and fruits.',
          buttonText: 'Shop Now',
          bgColor: '#F3E8E8',
          banner: logo2,
        },
        {
          id: 3,
          title: 'The Best Organic Products Online',
          description: 'Fresh vegetables and fruits available all week.',
          buttonText: 'Shop Now',
          bgColor: '#E7EAF3',
          banner: logo3,
        },
      ]
    },
  },
  async mounted() {
    console.log('🚀 App mounted, starting data load...')

    try {
      // Test backend connectivity first
      console.log('🔍 Testing backend connection...')

      // Load all product store data (includes categories, promotions, products)
      await this.productStore.loadAllData()

      console.log('✅ Backend data loaded successfully!')
      console.log('🛒 Products from backend:', this.productStore.products.length, 'items')

      // Always load local fallback data for UI components (categories/promotions for display)
      this.loadCategoriesLocal()
      this.loadPromotionsLocal()

      this.loading = false
      console.log('✅ Data loading complete!')
      console.log('📊 Local Categories:', this.categories.length, 'items')
      console.log('🎯 Local Promotions:', this.promotions.length, 'items')
      console.log('🛒 Store Products:', this.productStore.products.length, 'items')
    } catch (error) {
      console.error('❌ Backend connection failed:', error)
      console.log('🔄 Using fallback local data...')

      // Force the store to use local data if backend fails
      if (this.productStore.products.length === 0) {
        console.log('📦 Loading products from store local data...')
        // The store should have local fallback data in its state
      }

      // Load fallback data for UI components
      this.loadCategoriesLocal()
      this.loadPromotionsLocal()
      this.loading = false

      console.log('✅ Fallback data loaded!')
      console.log('🛒 Products available:', this.productStore.products.length)
    }
  },
}
</script>

<style scoped>
.app {
  background: #f7f8fa;
  min-height: 100vh;
  font-family:
    'Poppins',
    -apple-system,
    BlinkMacSystemFont,
    sans-serif;
  padding: 30px;
  margin: 0;
  box-sizing: border-box;
}

/* Loading Styles */
.loading {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 80px 20px;
  color: #3bb77e;
}

.spinner {
  width: 50px;
  height: 50px;
  border: 4px solid #e0e0e0;
  border-top: 4px solid #3bb77e;
  border-radius: 50%;
  animation: spin 1s linear infinite;
  margin-bottom: 20px;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

/* Main Content */
.main-content {
  max-width: 1400px;
  margin: 0 auto;
  padding: 0;
}

/* Section Headers - Enhanced */
.section-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 35px;
  padding-bottom: 20px;
  border-bottom: 2px solid #f1f1f1;
}

.section-header h2 {
  font-size: 38px;
  font-weight: 700;
  color: #253d4e;
  margin: 0;
  letter-spacing: -0.5px;
  line-height: 1.2;
}

/* Filter Buttons - Enhanced */
.category-filters,
.product-filters {
  display: flex;
  gap: 30px;
  align-items: center;
  background: #f8f9fa;
  padding: 8px 12px;
  border-radius: 12px;
  box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
}

.filter-btn {
  background: transparent;
  border: none;
  color: #7e7e7e;
  font-size: 15px;
  font-weight: 500;
  padding: 10px 16px;
  cursor: pointer;
  transition: all 0.3s ease;
  position: relative;
  border-radius: 8px;
  white-space: nowrap;
}

.filter-btn:hover {
  color: #3bb77e;
  background: rgba(59, 183, 126, 0.1);
}

.filter-btn.active {
  color: white;
  background: #3bb77e;
  font-weight: 600;
  box-shadow: 0 2px 8px rgba(59, 183, 126, 0.3);
}

.filter-btn.active::after {
  display: none;
}

/* Featured Categories Section */
.featured-categories {
  margin-bottom: 50px;
}

.categories-grid {
  display: grid;
  grid-template-columns: repeat(10, 1fr);
  gap: 15px;
  width: 100%;
  max-width: 1400px;
  margin: 0 auto;
}

.category-card {
  /* Background will be set inline using category.bgColor */
  border-radius: 12px;
  padding: 15px 8px;
  text-align: center;
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
  border: 1px solid rgba(255, 255, 255, 0.8);
  position: relative;
  overflow: hidden;
  min-height: 120px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

.category-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.category-icon {
  width: 60px;
  height: 60px;
  margin: 0 auto 8px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  background: rgba(255, 255, 255, 0.7);
  border: 1px solid rgba(255, 255, 255, 0.9);
  transition: all 0.3s ease;
}

.category-card:hover .category-icon {
  transform: scale(1.05);
}

.category-icon img {
  width: 45px;
  height: 45px;
  object-fit: contain;
  transition: all 0.3s ease;
  filter: brightness(0.8);
}

.category-card:hover .category-icon img {
  transform: scale(1.1);
}

.category-icon img[loading] {
  opacity: 0.7;
}

.category-card h3 {
  font-size: 13px;
  font-weight: 600;
  color: #253d4e;
  margin: 0 0 4px 0;
  line-height: 1.2;
  transition: color 0.3s ease;
  text-align: center;
}

.category-card p {
  font-size: 11px;
  color: #7e7e7e;
  margin: 0;
  font-weight: 500;
  transition: color 0.3s ease;
  text-align: center;
}

.category-card:hover p {
  color: #495057;
}

/* Promotional Banners */
.promotional-banners {
  margin-bottom: 50px;
}

.bottom-promotional-banners {
  margin-bottom: 60px;
  margin-top: 50px;
  background: white;
  padding: 40px;
  border-radius: 20px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
  border: 1px solid rgba(0, 0, 0, 0.05);
}

.banners-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
  gap: 25px;
}

/* Popular Products Section - Enhanced */
.popular-products {
  margin-bottom: 60px;
  background: white;
  padding: 40px;
  border-radius: 20px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
  border: 1px solid rgba(0, 0, 0, 0.05);
}

/* Menu Section */
.menu-section {
  margin-bottom: 40px;
}

/* Products Section */
.products-section {
  margin-bottom: 40px;
}

.products-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 25px;
  padding-bottom: 15px;
  border-bottom: 2px solid #e9ecef;
}

.products-header h2 {
  color: #253d4e;
  font-size: 28px;
  font-weight: 600;
  margin: 0;
}

.product-count {
  color: #7e7e7e;
  font-size: 16px;
  font-weight: 500;
}

/* Products Grid - Enhanced */
.products-grid-container {
  width: 100%;
  max-width: 1400px;
  margin: 0 auto;
  background: transparent;
  border-radius: 0;
}

.products-grid {
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  grid-template-rows: repeat(2, minmax(auto, 1fr));
  gap: 20px;
  padding: 20px 0;
  align-items: stretch;
}

.no-products {
  text-align: center;
  padding: 60px 20px;
  color: #7e7e7e;
  font-size: 18px;
  background: white;
  border-radius: 15px;
  border: 2px dashed #e0e0e0;
}

/* Demo Section (Hidden by default) */
.demo-section {
  margin-top: 60px;
  padding: 40px;
  background: white;
  border-radius: 20px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

/* 🟢 CATEGORY SECTION */
.category-list {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
  gap: 16px;
  padding: 20px 0;
  width: 100%;
}

.category-list > * {
  min-width: 120px;
  height: 177px;
  border-radius: 10px;
  transition:
    transform 0.25s ease,
    box-shadow 0.25s ease;
}

.category-list > *:hover {
  transform: translateY(-5px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
}

/* 🟣 PROMOTION SECTION */
.promotion-list {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 20px;
  width: 100%;
  margin-top: 40px;
}

.promotion-list > * {
  width: 100%;
  min-height: 250px;
  border-radius: 10px;
  transition:
    transform 0.25s ease,
    box-shadow 0.25s ease;
}

.promotion-list > *:hover {
  transform: translateY(-5px);
  box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
}

/* Demo Toggle */
.demo-toggle {
  text-align: center;
  padding: 40px 0;
  border-top: 1px solid #e9ecef;
  margin-top: 60px;
}

.toggle-btn {
  background: #3bb77e;
  color: white;
  border: none;
  padding: 12px 30px;
  border-radius: 25px;
  font-size: 16px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow: 0 4px 15px rgba(59, 183, 126, 0.3);
}

.toggle-btn:hover {
  background: #2e8b57;
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(59, 183, 126, 0.4);
}

/* Store Demo and Multi Getter Sections */
.store-demo-section,
.multi-getter-section {
  margin-top: 40px;
  background: white;
  border-radius: 15px;
  padding: 20px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.store-demo-section {
  padding: 0;
}

/* 💻 Responsive Design */
@media (max-width: 1200px) {
  .categories-grid {
    grid-template-columns: repeat(8, 1fr);
    gap: 12px;
  }

  .promotion-list {
    grid-template-columns: repeat(2, 1fr);
  }

  .products-grid {
    grid-template-columns: repeat(4, 1fr);
    grid-template-rows: repeat(3, 1fr);
    gap: 18px;
  }
}

@media (max-width: 768px) {
  .categories-grid {
    grid-template-columns: repeat(5, 1fr);
    gap: 10px;
  }

  .category-card {
    padding: 12px 6px;
    min-height: 100px;
  }

  .category-icon {
    width: 55px;
    height: 55px;
    margin: 0 auto 8px;
  }

  .category-icon img {
    width: 35px;
    height: 35px;
  }

  .category-card h3 {
    font-size: 12px;
    margin: 0 0 4px 0;
  }

  .category-card p {
    font-size: 10px;
  }

  .main-content {
    padding: 0 15px;
  }

  .app-header {
    padding: 30px 15px;
  }

  .app-title {
    font-size: 36px;
  }

  .app-subtitle {
    font-size: 16px;
  }

  .promotion-list {
    grid-template-columns: 1fr;
  }

  .category-list {
    grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
  }

  .products-grid {
    grid-template-columns: repeat(3, 1fr);
    grid-template-rows: repeat(4, 1fr);
    gap: 15px;
  }

  .products-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 10px;
  }

  .products-header h2 {
    font-size: 24px;
  }
}

@media (max-width: 480px) {
  .categories-grid {
    grid-template-columns: repeat(4, 1fr);
    gap: 8px;
  }

  .category-card {
    padding: 10px 4px;
    min-height: 90px;
  }

  .category-icon {
    width: 45px;
    height: 45px;
    margin: 0 auto 6px;
  }

  .category-icon img {
    width: 28px;
    height: 28px;
  }

  .category-card h3 {
    font-size: 11px;
    margin: 0 0 3px 0;
  }

  .category-card p {
    font-size: 9px;
  }

  .main-content {
    padding: 0 10px;
  }

  .app-header {
    padding: 25px 10px;
  }

  .app-title {
    font-size: 28px;
  }

  .category-list {
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
  }

  .products-grid {
    grid-template-columns: repeat(2, 1fr);
    grid-template-rows: repeat(5, 1fr);
    gap: 10px;
  }

  .demo-section {
    padding: 20px;
    margin-top: 40px;
  }
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>

<style>
/* Global styles to enable proper scrolling */
body {
  margin: 0;
  padding: 0;
  overflow-x: hidden;
  overflow-y: auto;
}

html {
  overflow-x: hidden;
  overflow-y: auto;
  scroll-behavior: smooth;
}

/* Enhanced SweetAlert2 Styles */
.custom-swal-popup {
  font-family:
    'Segoe UI',
    -apple-system,
    BlinkMacSystemFont,
    'Roboto',
    sans-serif !important;
  border-radius: 20px;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
  border: 2px solid #e8f5e8;
}

.custom-swal-title {
  font-family:
    'Segoe UI',
    -apple-system,
    BlinkMacSystemFont,
    'Roboto',
    sans-serif !important;
  font-size: 28px !important;
  font-weight: 700 !important;
  color: #253d4e !important;
  margin-bottom: 10px !important;
}

.custom-swal-confirm {
  font-family:
    'Segoe UI',
    -apple-system,
    BlinkMacSystemFont,
    'Roboto',
    sans-serif !important;
  border-radius: 10px !important;
  padding: 12px 30px !important;
  font-weight: 600 !important;
  font-size: 16px !important;
}

.custom-swal-cancel {
  font-family:
    'Segoe UI',
    -apple-system,
    BlinkMacSystemFont,
    'Roboto',
    sans-serif !important;
  border-radius: 10px !important;
  padding: 12px 30px !important;
  font-weight: 600 !important;
  font-size: 16px !important;
}

.custom-toast-popup {
  border-radius: 10px !important;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2) !important;
  border-left: 4px solid #3bb77e !important;
}

.swal2-success {
  border-color: #3bb77e !important;
}

.swal2-success [class^='swal2-success-line'] {
  background-color: #3bb77e !important;
}

.swal2-success .swal2-success-ring {
  border-color: rgba(59, 183, 126, 0.3) !important;
}

/* Store Demo Section */
.store-demo-section {
  margin-top: 40px;
  background: white;
  border-radius: 15px;
  padding: 0;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* Multi Getter Demo Section */
.multi-getter-section {
  margin-top: 40px;
  background: white;
  border-radius: 15px;
  padding: 20px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}
</style>
