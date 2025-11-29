<template>
  <div class="multi-getter">
    <h2>Multi Getters Demo</h2>

    <!-- Group Selector -->
    <section class="group-selector">
      <h3>Select Group to View Categories and Products</h3>
      <select v-model="currentGroupName" class="group-select">
        <option v-for="group in productStore.activeGroups" :key="group.id" :value="group.name">
          {{ group.name }}
        </option>
      </select>
    </section>

    <!-- Categories by Group -->
    <section class="categories-section" v-if="categories && categories.length > 0">
      <h3>Categories in "{{ currentGroupName }}" ({{ categories.length }})</h3>
      <div class="category-grid">
        <div v-for="category in categories" :key="category.id" class="category-card">
          <h4>{{ category.name }}</h4>
          <p>{{ category.description }}</p>
          <small>ID: {{ category.id }}</small>
        </div>
      </div>
    </section>

    <!-- Products by Group -->
    <section class="products-by-group" v-if="productsByGroup && productsByGroup.length > 0">
      <h3>Products in "{{ currentGroupName }}" ({{ productsByGroup.length }})</h3>
      <div class="product-grid">
        <div v-for="product in productsByGroup" :key="product.id" class="product-card">
          <h4>{{ product.name }}</h4>
          <p class="price">${{ product.price }}</p>
          <p class="sold">Sold: {{ product.countSold }} units</p>
          <p class="popular" v-if="product.countSold > 10">🔥 Popular!</p>
        </div>
      </div>
    </section>

    <!-- Popular Products -->
    <section class="popular-products">
      <h3>Popular Products (countSold > 10) - {{ popularProducts.length }} items</h3>
      <div class="product-grid">
        <div v-for="product in popularProducts" :key="product.id" class="product-card popular-item">
          <h4>{{ product.name }}</h4>
          <p class="price">${{ product.price }}</p>
          <p class="sold">🔥 Sold: {{ product.countSold }} units</p>
          <p class="rating">★ {{ product.rating }} ({{ product.reviewCount }} reviews)</p>
        </div>
      </div>
    </section>

    <!-- Products by Category -->
    <section class="products-by-category" v-if="selectedCategoryId">
      <h3>Products in Category ID {{ selectedCategoryId }} ({{ productsByCategory.length }})</h3>
      <div class="product-grid">
        <div v-for="product in productsByCategory" :key="product.id" class="product-card">
          <h4>{{ product.name }}</h4>
          <p class="price">${{ product.price }}</p>
          <p class="sold">Sold: {{ product.countSold }} units</p>
        </div>
      </div>
    </section>

    <!-- Category Selector for Product Filter -->
    <section class="category-selector">
      <h3>Filter Products by Category</h3>
      <select v-model="selectedCategoryId" class="category-select">
        <option value="">Select a category...</option>
        <option
          v-for="category in productStore.activeCategories"
          :key="category.id"
          :value="category.id"
        >
          {{ category.name }} (Group: {{ getGroupName(category.groupId) }})
        </option>
      </select>
    </section>

    <!-- Statistics -->
    <section class="statistics">
      <h3>Store Statistics</h3>
      <div class="stats-grid">
        <div class="stat-card">
          <h4>Total Groups</h4>
          <p class="stat-number">{{ productStore.activeGroups.length }}</p>
        </div>
        <div class="stat-card">
          <h4>Total Categories</h4>
          <p class="stat-number">{{ productStore.activeCategories.length }}</p>
        </div>
        <div class="stat-card">
          <h4>Total Products</h4>
          <p class="stat-number">{{ productStore.activeProducts.length }}</p>
        </div>
        <div class="stat-card">
          <h4>Popular Products</h4>
          <p class="stat-number">{{ popularProducts.length }}</p>
        </div>
        <div class="stat-card">
          <h4>Featured Products</h4>
          <p class="stat-number">{{ productStore.featuredProducts.length }}</p>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import { mapState } from 'pinia'
import { useProductStore } from '@/stores/productStore.js'

export default {
  name: 'MultiGetter',
  data() {
    return {
      currentGroupName: 'Milk & Dairies',
      selectedCategoryId: '',
    }
  },
  computed: {
    ...mapState(useProductStore, {
      popularProducts: 'getPopularProducts',
      categories(store) {
        return store.getCategoriesByGroup(this.currentGroupName)
      },
      productsByGroup(store) {
        return store.getProductsByGroup(this.currentGroupName)
      },
      productsByCategory(store) {
        return this.selectedCategoryId ? store.getProductsByCategory(this.selectedCategoryId) : []
      },
    }),

    productStore() {
      return useProductStore()
    },
  },
  methods: {
    getGroupName(groupId) {
      const group = this.productStore.groups.find((g) => g.id === groupId)
      return group ? group.name : 'Unknown'
    },
  },
  async mounted() {
    // Load data when component mounts
    try {
      await this.productStore.loadAllData()
    } catch (error) {
      console.log('Using local data as fallback')
    }
  },
}
</script>

<style scoped>
.multi-getter {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
  background: white;
  border-radius: 10px;
}

.group-selector,
.category-selector {
  margin-bottom: 30px;
  padding: 20px;
  background-color: #f8f9fa;
  border-radius: 8px;
}

.group-select,
.category-select {
  width: 100%;
  max-width: 400px;
  padding: 12px;
  font-size: 16px;
  border: 2px solid #ddd;
  border-radius: 6px;
  background: white;
  margin-top: 10px;
}

.group-select:focus,
.category-select:focus {
  border-color: #3498db;
  outline: none;
}

.category-grid,
.product-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
  gap: 20px;
  margin-top: 15px;
}

.category-card,
.product-card {
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  padding: 15px;
  background-color: #fafafa;
  transition:
    transform 0.2s ease,
    box-shadow 0.2s ease;
}

.category-card:hover,
.product-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.popular-item {
  border-color: #e74c3c;
  background-color: #fff5f5;
}

.product-card h4 {
  margin: 0 0 10px 0;
  color: #333;
  font-size: 1.1em;
}

.price {
  font-weight: bold;
  margin: 5px 0;
  color: #27ae60;
  font-size: 1.2em;
}

.sold {
  color: #8e44ad;
  font-weight: bold;
  margin: 5px 0;
}

.popular {
  color: #e74c3c;
  font-weight: bold;
  margin: 5px 0;
}

.rating {
  color: #f39c12;
  margin: 5px 0;
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 20px;
  margin-top: 15px;
}

.stat-card {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  padding: 20px;
  border-radius: 10px;
  text-align: center;
}

.stat-card h4 {
  margin: 0 0 10px 0;
  font-size: 1.1em;
  opacity: 0.9;
}

.stat-number {
  font-size: 2.5em;
  font-weight: bold;
  margin: 0;
}

section {
  margin-bottom: 30px;
}

h2 {
  color: #2c3e50;
  border-bottom: 3px solid #3498db;
  padding-bottom: 10px;
  margin-bottom: 20px;
}

h3 {
  color: #34495e;
  margin-bottom: 15px;
}

.categories-section,
.products-by-group,
.popular-products,
.products-by-category,
.statistics {
  padding: 20px;
  background-color: #ffffff;
  border-radius: 8px;
  border: 1px solid #e9ecef;
  margin-bottom: 20px;
}
</style>
