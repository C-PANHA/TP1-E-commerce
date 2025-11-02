<template>
  <div class="category-card" :style="{ backgroundColor: bgColor }">
    <img :src="image" :alt="title" class="category-image" />
    <div class="category-info">
      <h3 class="category-title">{{ title }}</h3>
      <p class="category-items">{{ items }} items</p>
    </div>
  </div>
</template>

<script setup>
defineProps({
  title: String,
  image: String,
  items: Number,
  bgColor: String
})
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