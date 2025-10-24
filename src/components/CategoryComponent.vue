<template>
  <div class="category-card" :style="{ backgroundColor: bgColor }">
    <img :src="image" alt="category image" />
    <h3>{{ title }}</h3>
    <p>{{ items }} items</p>
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
  width: 136px;
  height: 177px;
  border-radius: 10px;
  border: 1px solid #eee;
  text-align: center;
  padding: 10px;
  transition: 0.3s;
}
.category-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
.category-card img {
  width: 80px;
  height: 80px;
  object-fit: contain;
  margin-bottom: 8px;
}
.category-card h3 {
  font-size: 14px;
  color: #253d4e;
}
.category-card p {
  font-size: 12px;
  color: #7e7e7e;
}
</style>
