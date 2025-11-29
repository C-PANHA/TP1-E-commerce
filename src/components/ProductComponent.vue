<template>
  <div class="product-card">
    <!-- Discount Badge -->
    <div v-if="discountPercentage > 0" class="discount-badge" :class="discountBadgeColor">
      {{ discountPercentage }}%
    </div>

    <!-- Product Image -->
    <div class="product-image">
      <img :src="productImage" :alt="product.name" @error="handleImageError" loading="lazy" />
    </div>

    <!-- Product Info -->
    <div class="product-info">
      <div class="product-category">{{ categoryName }}</div>
      <h3 class="product-name">{{ product.name }}</h3>

      <!-- Rating -->
      <div class="product-rating">
        <div class="stars">
          <span
            v-for="i in 5"
            :key="i"
            class="star"
            :class="{ filled: i <= Math.floor(product.rating) }"
          >
            ★
          </span>
        </div>
        <span class="rating-text">({{ product.reviewCount || 0 }})</span>
      </div>

      <!-- Company/Brand -->
      <div class="product-company">{{ product.brand || 'Hola Foods' }}</div>

      <!-- Price -->
      <div class="product-pricing">
        <span class="current-price">${{ parseFloat(product.price).toFixed(2) }}</span>
        <span v-if="product.originalPrice > product.price" class="original-price">
          ${{ parseFloat(product.originalPrice).toFixed(2) }}
        </span>
      </div>

      <!-- Add to Cart -->
      <div class="product-actions">
        <div class="quantity-selector">
          <button @click="decreaseQuantity" :disabled="quantity <= 1">-</button>
          <span class="quantity">{{ quantity }}</span>
          <button @click="increaseQuantity">+</button>
        </div>
        <button class="add-to-cart-btn" @click="addToCart">
          Add
          <span class="add-icon">+</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import { useProductStore } from '@/stores/productStore.js'

export default {
  name: 'ProductComponent',
  props: {
    product: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      quantity: 1,
    }
  },
  computed: {
    productStore() {
      return useProductStore()
    },

    categoryName() {
      // Try to find category in store first
      const category = this.productStore.categories.find(
        (cat) => cat.id === this.product.categoryId,
      )
      if (category) {
        return category.name || category.title
      }

      // Fallback to product group or generic name
      if (this.product.group) {
        return this.product.group.charAt(0).toUpperCase() + this.product.group.slice(1)
      }

      return 'Unknown'
    },

    discountPercentage() {
      if (this.product.originalPrice > this.product.price) {
        return Math.round(
          ((this.product.originalPrice - this.product.price) / this.product.originalPrice) * 100,
        )
      }
      return 0
    },

    discountBadgeColor() {
      const percentage = this.discountPercentage
      if (percentage >= 30) return 'high-discount'
      if (percentage >= 20) return 'medium-discount'
      if (percentage >= 10) return 'low-discount'
      return 'sale'
    },

    productImage() {
      // Handle different image formats
      if (this.product.images && this.product.images.length > 0) {
        return this.product.images[0]
      }

      // Handle backend image format (string with JSON array)
      if (this.product.image) {
        try {
          // Backend returns image as stringified JSON array
          const imageArray = JSON.parse(this.product.image)
          if (imageArray && imageArray.length > 0) {
            // Convert backend path to frontend URL
            const backendImage = imageArray[0]
            return `http://localhost:3000/${backendImage.replace(/\\\\/g, '/')}`
          }
        } catch (error) {
          // If parsing fails, treat as regular string
          if (typeof this.product.image === 'string') {
            return this.product.image.includes('http')
              ? this.product.image
              : `http://localhost:3000/${this.product.image}`
          }
        }
      }

      // Fallback to available product images based on product ID
      const fallbackImages = [
        '/src/assets/images/products/product1.jpg',
        '/src/assets/images/products/product2.png',
        '/src/assets/images/products/product3.png',
        '/src/assets/images/products/product4.png',
        '/src/assets/images/products/product5.png',
        '/src/assets/images/products/product6.png',
        '/src/assets/images/products/product7.png',
        '/src/assets/images/products/product8.png',
        '/src/assets/images/products/product9.png',
        '/src/assets/images/products/product10.png',
      ]

      const imageIndex = (this.product.id - 1) % fallbackImages.length
      return fallbackImages[imageIndex]
    },
  },
  methods: {
    increaseQuantity() {
      if (this.quantity < this.product.stock) {
        this.quantity++
      }
    },

    decreaseQuantity() {
      if (this.quantity > 1) {
        this.quantity--
      }
    },

    addToCart() {
      this.$emit('add-to-cart', {
        product: this.product,
        quantity: this.quantity,
      })

      // Reset quantity after adding to cart
      this.quantity = 1

      // Show success feedback (you can customize this)
      console.log(`Added ${this.quantity} x ${this.product.name} to cart`)
    },

    handleImageError(event) {
      // Fallback to a default category image if product image fails
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
  },
}
</script>

<style scoped>
.product-card {
  position: relative;
  background: white;
  border-radius: 15px;
  padding: 20px;
  box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
  transition: all 0.3s ease;
  border: 1px solid #f3f3f3;
}

.product-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
}

.discount-badge {
  position: absolute;
  top: 15px;
  left: 15px;
  padding: 4px 8px;
  border-radius: 20px;
  font-size: 12px;
  font-weight: 600;
  color: white;
  z-index: 2;
}

.discount-badge.high-discount {
  background-color: #ff6b6b; /* Red for high discounts */
}

.discount-badge.medium-discount {
  background-color: #ffa726; /* Orange for medium discounts */
}

.discount-badge.low-discount {
  background-color: #66bb6a; /* Green for low discounts */
}

.discount-badge.sale {
  background-color: #42a5f5; /* Blue for sales */
}

.product-image {
  text-align: center;
  margin-bottom: 15px;
  height: 150px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.product-image img {
  max-width: 100%;
  max-height: 100%;
  object-fit: contain;
  border-radius: 8px;
}

.product-info {
  text-align: left;
}

.product-category {
  color: #7e7e7e;
  font-size: 12px;
  font-weight: 500;
  margin-bottom: 5px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.product-name {
  font-size: 16px;
  font-weight: 600;
  color: #253d4e;
  margin: 0 0 10px 0;
  line-height: 1.3;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.product-rating {
  display: flex;
  align-items: center;
  gap: 5px;
  margin-bottom: 8px;
}

.stars {
  display: flex;
  gap: 1px;
}

.star {
  color: #e0e0e0;
  font-size: 14px;
}

.star.filled {
  color: #ffc107;
}

.rating-text {
  color: #7e7e7e;
  font-size: 12px;
}

.product-company {
  color: #7e7e7e;
  font-size: 12px;
  margin-bottom: 10px;
  font-weight: 500;
}

.product-pricing {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-bottom: 15px;
}

.current-price {
  color: #3bb77e;
  font-size: 18px;
  font-weight: 700;
}

.original-price {
  color: #7e7e7e;
  font-size: 14px;
  text-decoration: line-through;
}

.product-actions {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 10px;
}

.quantity-selector {
  display: flex;
  align-items: center;
  border: 1px solid #e0e0e0;
  border-radius: 6px;
  overflow: hidden;
}

.quantity-selector button {
  width: 30px;
  height: 30px;
  border: none;
  background: #f8f9fa;
  color: #7e7e7e;
  font-size: 16px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s ease;
}

.quantity-selector button:hover:not(:disabled) {
  background: #3bb77e;
  color: white;
}

.quantity-selector button:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.quantity {
  padding: 0 12px;
  font-size: 14px;
  font-weight: 600;
  color: #253d4e;
  min-width: 30px;
  text-align: center;
}

.add-to-cart-btn {
  background: #3bb77e;
  color: white;
  border: none;
  padding: 8px 16px;
  border-radius: 6px;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  gap: 5px;
  flex: 1;
  justify-content: center;
}

.add-to-cart-btn:hover {
  background: #2e8b57;
  transform: translateY(-1px);
}

.add-icon {
  font-size: 16px;
  font-weight: bold;
}

@media (max-width: 768px) {
  .product-card {
    padding: 15px;
  }

  .product-name {
    font-size: 14px;
  }

  .current-price {
    font-size: 16px;
  }

  .product-actions {
    flex-direction: column;
    gap: 10px;
  }

  .add-to-cart-btn {
    width: 100%;
  }
}
</style>
