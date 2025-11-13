<template>
  <div class="app">
    <h1>My Vue Practice - Components</h1>

    <!-- Loading State -->
    <div v-if="loading" class="loading">
      <div class="spinner"></div>
      <p>Loading products...</p>
    </div>

    <!-- Main Content -->
    <div v-else>
      <!-- 🟢 CATEGORY SECTION -->
      <div class="category-list">
        <CategoryComponent
          v-for="(category, index) in categories"
          :key="category.id || index"
          :title="category.title"
          :image="category.image"
          :items="category.items"
          :bgColor="category.bgColor"
        />
      </div>

      <!-- 🟣 PROMOTION SECTION -->
      <div class="promotion-list">
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
    </div>
  </div>
</template>

<script>
import CategoryComponent from './components/CategoryComponent.vue'
import PromotionComponent from './components/PromotionComponent.vue'
import ButtonComponent from './components/ButtonComponent.vue'
import Swal from 'sweetalert2'
import axios from 'axios'

// Import local images
import image1 from './assets/images/image1.png'
import image2 from './assets/images/image2.png'
import image3 from './assets/images/image3.png'
import image4 from './assets/images/image4.png'
import image5 from './assets/images/image5.png'
import image6 from './assets/images/image6.png'
import image7 from './assets/images/image7.png'
import image8 from './assets/images/image8.png'
import image9 from './assets/images/image9.png'
import image10 from './assets/images/image10.png'

import logo1 from './assets/images/logo1.png'
import logo2 from './assets/images/logo2.png'
import logo3 from './assets/images/logo3.png'

export default {
  name: 'App',
  components: {
    CategoryComponent,
    PromotionComponent,
    ButtonComponent,
  },
  data() {
    return {
      categories: [],
      promotions: [],
      loading: true,
    }
  },
  methods: {
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
  mounted() {
    console.log('🚀 App mounted, starting data load...')
    Promise.all([this.loadCategories(), this.loadPromotions()]).finally(() => {
      this.loading = false
      console.log('✅ Data loading complete!')
      console.log('📊 Categories:', this.categories.length, 'items')
      console.log('🎯 Promotions:', this.promotions.length, 'items')
    })
  },
}
</script>

<style scoped>
.app {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  padding: 40px;
  font-family: 'Poppins', sans-serif;
  text-align: center;
  min-height: 100vh;
  width: 100%;
  margin: 0 auto;
  border-radius: 0;
  box-shadow: none;
  animation: fadeIn 1s ease-in-out;
  overflow: hidden;
  box-sizing: border-box;
}

h1 {
  margin-bottom: 30px;
  color: #ffffff;
  font-size: 32px;
  font-weight: 700;
  text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

/* Loading Styles */
.loading {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 60px 0;
  color: white;
}

.spinner {
  width: 50px;
  height: 50px;
  border: 5px solid rgba(255, 255, 255, 0.3);
  border-top: 5px solid white;
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

/* 💻 Responsive tweaks */
@media (max-width: 1200px) {
  .promotion-list {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 768px) {
  .app {
    padding: 20px;
  }

  .promotion-list {
    grid-template-columns: 1fr;
  }

  .category-list {
    grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
  }

  h1 {
    font-size: 24px;
  }
}

@media (max-width: 480px) {
  .app {
    padding: 15px;
  }

  .category-list {
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
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
/* Global styles to remove body scroll */
body {
  margin: 0;
  padding: 0;
  overflow: hidden;
}

html {
  overflow: hidden;
}

/* Enhanced SweetAlert2 Styles */
.custom-swal-popup {
  border-radius: 20px;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
  border: 2px solid #e8f5e8;
}

.custom-swal-title {
  font-size: 28px !important;
  font-weight: 700 !important;
  color: #253d4e !important;
  margin-bottom: 10px !important;
}

.custom-swal-confirm {
  border-radius: 10px !important;
  padding: 12px 30px !important;
  font-weight: 600 !important;
  font-size: 16px !important;
}

.custom-swal-cancel {
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
</style>
