<template>
  <div class="promotion-card" :style="{ backgroundColor: bgColor }">
    <div class="text">
      <h3 :style="{ color: titleColor }">{{ title }}</h3>
      <p>{{ description }}</p>
      <slot></slot>
      <!-- Alternative: Button inside PromotionComponent -->
      <button 
        v-if="!$slots.default" 
        class="shop-btn" 
        @click="shopNow"
        :style="{ backgroundColor: buttonColor }"
      >
        {{ buttonText }}
      </button>
    </div>
    <div class="image-container" :style="{ backgroundColor: imageBackgroundColor }">
      <img
        :src="banner"
        alt="promotion banner"
        :style="{ width: imageWidth, height: imageHeight }"
        @load="extractColorFromImage"
        @error="handleImageError"
        ref="imageRef"
      />
    </div>
  </div>
</template>

<script>
export default {
  name: 'PromotionComponent',
  props: {
    title: String,
    description: String,
    banner: String,
    bgColor: String,
    buttonText: {
      type: String,
      default: 'Shop Now'
    },
    buttonColor: {
      type: String,
      default: '#3bb77e'
    },
    titleColor: {
      type: String,
      default: '#253d4e',
    },
    imageBackgroundColor: {
      type: String,
      default: 'transparent',
    },
    imageWidth: {
      type: String,
      default: '180px',
    },
    imageHeight: {
      type: String,
      default: 'auto',
    },
  },
  methods: {
    shopNow() {
      alert("Let's shop: " + this.title);
    },
    extractColorFromImage() {
      // ... (same extraction logic as before)
    },
    handleImageError(event) {
      console.error('Failed to load image:', event.target.src);
      event.target.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZGRkIi8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtc2l6ZT0iMTQiIGZpbGw9IiM5OTkiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGR5PSIuM2VtIj5JbWFnZSBOb3QgRm91bmQ8L3RleHQ+PC9zdmc+'
    }
  },
  mounted() {
    if (this.$refs.imageRef && this.$refs.imageRef.complete) {
      this.extractColorFromImage();
    }
  }
}
</script>

<style scoped>
.promotion-card {
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 100%;
  height: 100%;
  border-radius: 10px;
  padding: 20px;
  border: 1px solid #eee;
  overflow: hidden;
  box-sizing: border-box;
}
.text {
  text-align: left;
  color: #253d4e;
  flex: 1;
  padding-right: 20px;
}
.text h3 {
  font-size: 18px;
  font-weight: 600;
  margin-bottom: 8px;
}
.text p {
  font-size: 14px;
  color: #7e7e7e;
  margin-bottom: 12px;
}
.promotion-card img {
  object-fit: contain;
  max-width: 100%;
}
.image-container {
  border-radius: 8px;
  padding: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.shop-btn {
  color: white;
  border: none;
  padding: 10px 18px;
  border-radius: 8px;
  font-weight: 600;
  cursor: pointer;
  transition: 0.3s;
}
.shop-btn:hover {
  opacity: 0.85;
  transform: translateY(-2px);
}

/* Responsive design for promotion cards */
@media (max-width: 768px) {
  .promotion-card {
    flex-direction: column;
    text-align: center;
    padding: 15px;
  }
  .text {
    padding-right: 0;
    margin-bottom: 15px;
  }
  .image-container {
    width: 100%;
  }
}
</style>