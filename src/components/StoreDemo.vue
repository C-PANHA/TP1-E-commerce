<template>
  <div class="store-demo">
    <h2>Product Store Demo</h2>

    <!-- Loading States -->
    <div v-if="productStore.isLoading" class="loading">
      <p>Loading data...</p>
    </div>

    <!-- Error States -->
    <div v-if="productStore.hasErrors" class="errors">
      <h3>Errors:</h3>
      <ul>
        <li v-if="productStore.errors.groups">Groups: {{ productStore.errors.groups }}</li>
        <li v-if="productStore.errors.categories">
          Categories: {{ productStore.errors.categories }}
        </li>
        <li v-if="productStore.errors.promotions">
          Promotions: {{ productStore.errors.promotions }}
        </li>
        <li v-if="productStore.errors.products">Products: {{ productStore.errors.products }}</li>
      </ul>
    </div>

    <!-- Groups Section -->
    <section class="groups-section">
      <h3>Product Groups ({{ productStore.activeGroups.length }})</h3>
      <div class="group-grid">
        <div v-for="group in productStore.activeGroups" :key="group.id" class="group-card">
          <h4>{{ group.name }}</h4>
          <p>{{ group.description }}</p>
          <small>Categories: {{ productStore.getCategoriesByGroup(group.id).length }}</small>
        </div>
      </div>
    </section>

    <!-- Featured Products -->
    <section class="featured-products">
      <h3>Featured Products ({{ productStore.featuredProducts.length }})</h3>
      <div class="product-grid">
        <div
          v-for="product in productStore.featuredProducts.slice(0, 6)"
          :key="product.id"
          class="product-card"
        >
          <h4>{{ product.name }}</h4>
          <p class="price">
            <span class="current">${{ product.price }}</span>
            <span v-if="product.originalPrice > product.price" class="original">
              ${{ product.originalPrice }}
            </span>
          </p>
          <p class="rating">★ {{ product.rating }} ({{ product.reviewCount }} reviews)</p>
          <p class="stock">Stock: {{ product.stock }}</p>
        </div>
      </div>
    </section>

    <!-- Active Promotions -->
    <section class="promotions">
      <h3>Active Promotions ({{ productStore.activePromotions.length }})</h3>
      <div class="promotion-list">
        <div
          v-for="promotion in productStore.activePromotions"
          :key="promotion.id"
          class="promotion-card"
        >
          <h4>{{ promotion.title }}</h4>
          <p>{{ promotion.description }}</p>
          <p class="discount">
            {{
              promotion.discountType === 'percentage'
                ? `${promotion.discountValue}% OFF`
                : promotion.discountType === 'fixed'
                  ? `$${promotion.discountValue} OFF`
                  : 'FREE SHIPPING'
            }}
          </p>
          <small> Valid until: {{ new Date(promotion.endDate).toLocaleDateString() }} </small>
        </div>
      </div>
    </section>

    <!-- Actions -->
    <section class="actions">
      <h3>Store Actions</h3>
      <div class="action-buttons">
        <button @click="loadAllData" :disabled="productStore.isLoading">Reload All Data</button>
        <button @click="productStore.clearErrors">Clear Errors</button>
        <button @click="searchProducts">Search "smartphone"</button>
      </div>

      <!-- Search Results -->
      <div v-if="searchResults.length > 0" class="search-results">
        <h4>Search Results ({{ searchResults.length }})</h4>
        <div class="product-grid">
          <div v-for="product in searchResults" :key="product.id" class="product-card">
            <h5>{{ product.name }}</h5>
            <p class="price">${{ product.price }}</p>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useProductStore } from '@/stores/productStore.js'

const productStore = useProductStore()
const searchResults = ref([])

onMounted(async () => {
  // Try to load data from backend, fallback to local data
  await loadAllData()
})

const loadAllData = async () => {
  try {
    await productStore.loadAllData()
  } catch (error) {
    console.log('Using local data as fallback')
  }
}

const searchProducts = () => {
  searchResults.value = productStore.searchProducts('smartphone')
}
</script>

<style scoped>
.store-demo {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
}

.loading {
  text-align: center;
  padding: 20px;
  background-color: #f0f8ff;
  border-radius: 8px;
  margin-bottom: 20px;
}

.errors {
  background-color: #ffe6e6;
  border: 1px solid #ff9999;
  border-radius: 8px;
  padding: 15px;
  margin-bottom: 20px;
}

.errors ul {
  margin: 10px 0 0 20px;
}

.group-grid,
.product-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
  gap: 20px;
  margin-top: 15px;
}

.group-card,
.product-card,
.promotion-card {
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  padding: 15px;
  background-color: #fafafa;
}

.product-card h4,
.product-card h5 {
  margin: 0 0 10px 0;
  color: #333;
}

.price {
  font-weight: bold;
  margin: 5px 0;
}

.price .current {
  color: #e74c3c;
  font-size: 1.1em;
}

.price .original {
  color: #999;
  text-decoration: line-through;
  margin-left: 8px;
  font-size: 0.9em;
}

.rating {
  color: #f39c12;
  margin: 5px 0;
}

.stock {
  color: #27ae60;
  font-size: 0.9em;
  margin: 5px 0;
}

.promotion-list {
  display: flex;
  flex-direction: column;
  gap: 15px;
  margin-top: 15px;
}

.promotion-card h4 {
  color: #8e44ad;
  margin: 0 0 10px 0;
}

.discount {
  font-weight: bold;
  color: #e74c3c;
  font-size: 1.1em;
  margin: 10px 0;
}

.actions {
  margin-top: 30px;
  padding: 20px;
  background-color: #f8f9fa;
  border-radius: 8px;
}

.action-buttons {
  display: flex;
  gap: 15px;
  flex-wrap: wrap;
  margin-bottom: 20px;
}

.action-buttons button {
  padding: 10px 20px;
  background-color: #3498db;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 14px;
}

.action-buttons button:hover {
  background-color: #2980b9;
}

.action-buttons button:disabled {
  background-color: #bdc3c7;
  cursor: not-allowed;
}

.search-results {
  margin-top: 20px;
  padding: 15px;
  background-color: white;
  border-radius: 8px;
  border: 1px solid #ddd;
}

section {
  margin-bottom: 30px;
}

h2 {
  color: #2c3e50;
  border-bottom: 2px solid #3498db;
  padding-bottom: 10px;
}

h3 {
  color: #34495e;
  margin-bottom: 15px;
}
</style>
