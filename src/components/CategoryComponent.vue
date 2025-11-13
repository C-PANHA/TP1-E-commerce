<template>
  <div class="category-card" :style="{ backgroundColor: bgColor }">
    <img
      :src="fixedImageUrl"
      :alt="title"
      class="category-image"
      @error="handleImageError"
      @load="handleImageLoad"
    />
    <div class="category-info">
      <h3 class="category-title">{{ title }}</h3>
      <p class="category-items">{{ items }} items</p>
    </div>
  </div>
</template>

<script>
export default {
  name: 'CategoryComponent',
  props: {
    title: String,
    image: String,
    items: Number,
    bgColor: String,
  },
  computed: {
    // Fix malformed URLs from backend
    fixedImageUrl() {
      if (!this.image) return ''

      // If it's already a valid URL or local import, return as is
      if (
        this.image.startsWith('data:') ||
        this.image.startsWith('/') ||
        this.image.includes('/_nuxt/') ||
        this.image.includes('/assets/') ||
        this.image.startsWith('blob:')
      ) {
        return this.image
      }

      // Fix malformed backend URLs
      let url = this.image

      // Fix missing slash after domain (e.g., 'localhost:3000uploads' -> 'localhost:3000/uploads')
      url = url.replace(/localhost:(\d+)([^/])/, 'localhost:$1/$2')

      // Fix backslashes to forward slashes
      url = url.replace(/\\/g, '/')

      // Ensure http protocol
      if (!url.startsWith('http://') && !url.startsWith('https://')) {
        url = 'http://' + url
      }

      console.log('🔧 Fixed category image URL:', this.image, '->', url)
      return url
    },
  },
  methods: {
    handleImageLoad() {
      console.log('✅ Category image loaded successfully:', this.title)
    },
    handleImageError(event) {
      const originalUrl = this.image
      const attemptedUrl = event.target.src

      console.error('❌ Failed to load category image:')
      console.error('   Category:', this.title)
      console.error('   Original URL:', originalUrl)
      console.error('   Attempted URL:', attemptedUrl)

      // Create a fallback placeholder with category initial
      const initial = this.title ? this.title.charAt(0).toUpperCase() : '?'
      const placeholder =
        'data:image/svg+xml;base64,' +
        btoa(`
        <svg width="60" height="60" xmlns="http://www.w3.org/2000/svg">
          <rect width="100%" height="100%" fill="#f8f9fa" stroke="#dee2e6" stroke-width="2" rx="8"/>
          <text x="50%" y="50%" font-family="Arial, sans-serif" font-size="24" font-weight="bold" fill="#6c757d" text-anchor="middle" dy="0.3em">
            ${initial}
          </text>
        </svg>
      `)

      event.target.src = placeholder
      console.log('🔄 Using placeholder for category:', this.title)
    },
  },
}
</script>

<style scoped>
.category-card {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 15px;
  border-radius: 10px;
  text-align: center;
  cursor: pointer;
  transition: all 0.3s ease;
  box-sizing: border-box;
}

.category-image {
  width: 60px;
  height: 60px;
  object-fit: contain;
  margin-bottom: 10px;
}

.category-title {
  font-size: 14px;
  font-weight: 600;
  color: #253d4e;
  margin: 0 0 5px 0;
  line-height: 1.2;
}

.category-items {
  font-size: 12px;
  color: #7e7e7e;
  margin: 0;
}

.category-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
}

/* Responsive design */
@media (max-width: 480px) {
  .category-card {
    padding: 10px;
  }

  .category-image {
    width: 50px;
    height: 50px;
  }

  .category-title {
    font-size: 12px;
  }

  .category-items {
    font-size: 11px;
  }
}
</style>
