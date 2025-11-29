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
        :src="fixedBannerUrl"
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
      default: 'Shop Now',
    },
    buttonColor: {
      type: String,
      default: '#3bb77e',
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
  computed: {
    // Fix malformed URLs from backend
    fixedBannerUrl() {
      if (!this.banner) return ''

      // If it's already a valid URL or local import, return as is
      if (
        this.banner.startsWith('data:') ||
        this.banner.startsWith('/') ||
        this.banner.includes('/_nuxt/') ||
        this.banner.includes('/assets/')
      ) {
        return this.banner
      }

      // Fix malformed backend URLs
      let url = this.banner

      // Fix missing slash after domain (e.g., 'localhost:3000uploads' -> 'localhost:3000/uploads')
      url = url.replace(/localhost:(\d+)([^/])/, 'localhost:$1/$2')

      // Fix backslashes to forward slashes
      url = url.replace(/\\/g, '/')

      // Ensure http protocol
      if (!url.startsWith('http://') && !url.startsWith('https://')) {
        url = 'http://' + url
      }

      console.log('🔧 Fixed image URL:', this.banner, '->', url)
      return url
    },
  },
  methods: {
    shopNow() {
      alert("Let's shop: " + this.title)
    },
    extractColorFromImage() {
      // ... (same extraction logic as before)
    },
    handleImageError(event) {
      const originalUrl = this.banner
      const attemptedUrl = event.target.src

      console.error('❌ Failed to load promotion image:')
      console.error('   Original URL:', originalUrl)
      console.error('   Attempted URL:', attemptedUrl)

      // Try to load a fallback placeholder
      const placeholder =
        'data:image/svg+xml;base64,' +
        btoa(`
        <svg width="200" height="120" xmlns="http://www.w3.org/2000/svg">
          <rect width="100%" height="100%" fill="#f8f9fa" stroke="#dee2e6" stroke-width="2"/>
          <text x="50%" y="40%" font-family="Arial, sans-serif" font-size="14" fill="#6c757d" text-anchor="middle">
            Promotion Image
          </text>
          <text x="50%" y="60%" font-family="Arial, sans-serif" font-size="12" fill="#adb5bd" text-anchor="middle">
            Not Available
          </text>
        </svg>
      `)

      event.target.src = placeholder
      console.log('🔄 Using placeholder image for promotion')
    },
  },
  mounted() {
    if (this.$refs.imageRef && this.$refs.imageRef.complete) {
      this.extractColorFromImage()
    }
  },
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
