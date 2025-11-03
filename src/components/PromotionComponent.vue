  <template>
  <div class="promotion-card" :style="{ backgroundColor:  bgColor }">
    <div class="text">
      <h3 :style="{ color: titleColor }">{{ title }}</h3>
      <p>{{ description }}</p>
      <slot></slot>
    </div>
    <div class="image-container" :style="{ backgroundColor: imageBackgroundColor }">
      <img
        :src="banner"
        alt="promotion banner"
        :style="{ width: imageWidth, height: imageHeight }"
        @load="extractColorFromImage"
        ref="imageRef"
      />
    </div>
  </div>
</template>

<script setup>

import { ref, onMounted } from 'vue'

const props = defineProps({
  title: String,
  description: String,
  banner: String,
  bgColor: String,
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
})

const imageRef = ref(null)
const extractedColor = ref(null)

const extractColorFromImage = () => {
  if (!imageRef.value) return

  const canvas = document.createElement('canvas')
  const ctx = canvas.getContext('2d')
  const img = imageRef.value

  canvas.width = img.naturalWidth || img.width
  canvas.height = img.naturalHeight || img.height

  ctx.drawImage(img, 0, 0)

  try {
    const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height)
    const data = imageData.data

    // Sample colors from the image (every 10th pixel for performance)
    const colors = []
    for (let i = 0; i < data.length; i += 40) {
      // RGBA = 4 bytes per pixel, sample every 10th pixel
      const r = data[i]
      const g = data[i + 1]
      const b = data[i + 2]
      const a = data[i + 3]

      // Skip transparent pixels
      if (a > 128) {
        colors.push({ r, g, b })
      }
    }

    if (colors.length > 0) {
      // Calculate average color
      const avgR = Math.round(colors.reduce((sum, color) => sum + color.r, 0) / colors.length)
      const avgG = Math.round(colors.reduce((sum, color) => sum + color.g, 0) / colors.length)
      const avgB = Math.round(colors.reduce((sum, color) => sum + color.b, 0) / colors.length)

      // Convert to hex
      const hexR = avgR.toString(16).padStart(2, '0')
      const hexG = avgG.toString(16).padStart(2, '0')
      const hexB = avgB.toString(16).padStart(2, '0')

      extractedColor.value = `#${hexR}${hexG}${hexB}`
    }
  } catch (error) {
    console.warn('Could not extract color from image:', error)
  }
}

onMounted(() => {
  if (imageRef.value && imageRef.value.complete) {
    extractColorFromImage()
  }
})
</script>

<style scoped>
.promotion-card {
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 512px;
  height: 300px;
  border-radius: 10px;
  padding: 20px;
  border: 1px solid #eee;
  overflow: hidden;
}
.text {
  text-align: left;
  color: #253d4e;
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
}
.image-container {
  border-radius: 8px;
  padding: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>
