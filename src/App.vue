<template>
  <div class="app">
    <h1>My Vue Practice - Components</h1>

    <!-- 🟢 CATEGORY SECTION -->
    <div class="category-list">
      <CategoryComponent
        v-for="(category, index) in categories"
        :key="index"
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
        :key="index"
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
</template>

<script>
import CategoryComponent from './components/CategoryComponent.vue'
import PromotionComponent from './components/PromotionComponent.vue'
import ButtonComponent from './components/ButtonComponent.vue'
import Swal from 'sweetalert2'

// 🖼 Import category images
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

// 🖼 Import promotion images
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
      // 🟢 Category Data
      categories: [
        { title: 'Cake & Milk', image: image1, items: 14, bgColor: '#FEEFEA' },
        { title: 'Peach', image: image2, items: 17, bgColor: '#FFF3EB' },
        { title: 'Organic Kiwi', image: image3, items: 21, bgColor: '#EAF7E9' },
        { title: 'Red Apple', image: image4, items: 68, bgColor: '#FEEAEA' },
        { title: 'Snack', image: image5, items: 34, bgColor: '#FFFBEA' },
        { title: 'Black Plum', image: image6, items: 25, bgColor: '#F3EBFF' },
        { title: 'Vegetables', image: image7, items: 65, bgColor: '#EAF7F0' },
        { title: 'Headphone', image: image8, items: 33, bgColor: '#EBF5FF' },
        { title: 'Cereal', image: image9, items: 40, bgColor: '#FFF5EB' },
        { title: 'Orange', image: image10, items: 63, bgColor: '#FFF0E5' },
      ],
      // 🟣 Promotion Data
      promotions: [
        {
          title: 'Everyday Fresh & Clean with Our Products',
          description: 'Healthy and fresh groceries delivered to your home.',
          banner: logo1,
          buttonText: 'Shop Now',
          bgColor: '#FFF3EB',
        },
        {
          title: 'Make your Breakfast Healthy and Easy',
          description: 'Start your day with milk and fruits.',
          banner: logo2,
          buttonText: 'Shop Now',
          bgColor: '#F3E8E8',
        },
        {
          title: 'The Best Organic Products Online',
          description: 'Fresh vegetables and fruits available all week.',
          banner: logo3,
          buttonText: 'Shop Now',
          bgColor: '#E7EAF3',
        },
      ],
    }
  },
  methods: {
    shopNow(promotion) {
      Swal.fire({
        title: 'Ready to shop?',
        html: `
        <div style="text-align: left; margin: 15px 0;">
          <p style="margin-bottom: 10px; font-weight: 600; color: #253d4e;">You selected:</p>
          <p style="background: #f8f9fa; padding: 10px; border-radius: 8px; border-left: 4px solid #3bb77e; color: #253d4e;">
            ${promotion.title}
          </p>
        </div>
        <p style="color: #666; font-style: italic; margin-top: 15px;">✨ Drag this dialog anywhere! ✨</p>
      `,
        icon: 'success',
        draggable: true,
        showCancelButton: true,
        confirmButtonText: 'Add to Cart 🛒',
        cancelButtonText: 'Continue Browsing',
        confirmButtonColor: '#3bb77e',
        cancelButtonColor: '#6c757d',
        width: 500,
        padding: '2em',
        background: '#ffffff',
        backdrop: `
        rgba(0,0,0,0.4)
        url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%233bb77e' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E")
        left top
        no-repeat
      `,
        customClass: {
          container: 'custom-swal-container',
          popup: 'custom-swal-popup',
          title: 'custom-swal-title',
          confirmButton: 'custom-swal-confirm',
          cancelButton: 'custom-swal-cancel',
        },
      }).then((result) => {
        if (result.isConfirmed) {
          // Show success message for adding to cart
          Swal.fire({
            title: 'Added to Cart! 🎉',
            text: `${promotion.title} has been added to your shopping cart.`,
            icon: 'success',
            timer: 2000,
            showConfirmButton: false,
            position: 'top-end',
            toast: true,
            background: '#f8f9fa',
            customClass: {
              popup: 'custom-toast-popup',
            },
          })
        }
      })
    },
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
  overflow: hidden; /* Remove scroll */
  box-sizing: border-box;
}

h1 {
  margin-bottom: 30px;
  color: #ffffff;
  font-size: 32px;
  font-weight: 700;
  text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

/* 🟢 CATEGORY SECTION - FIXED */
.category-list {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
  gap: 16px;
  padding: 20px 0;
  width: 100%;
  overflow: hidden; /* Remove scroll */
}

.category-list > * {
  min-width: 120px;
  height: 177px;
  border-radius: 10px;
  transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.category-list > *:hover {
  transform: translateY(-5px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
}

/* 🟣 PROMOTION SECTION - FIXED */
.promotion-list {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 20px;
  width: 100%;
  margin-top: 40px;
  overflow: hidden; /* Remove scroll */
}

.promotion-list > * {
  width: 100%;
  min-height: 250px;
  border-radius: 10px;
  transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.promotion-list > *:hover {
  transform: translateY(-5px);
  box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
}

/* 💻 Responsive tweaks - IMPROVED */
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
  overflow: hidden; /* Remove body scroll */
}

html {
  overflow: hidden; /* Remove html scroll */
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