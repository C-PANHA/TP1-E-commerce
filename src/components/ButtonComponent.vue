<template>
  <button class="shop-btn" :style="{ backgroundColor: color }" @click="handleClick">
    {{ label }}
  </button>
</template>

<script>
export default {
  name: 'ButtonComponent',
  props: {
    label: String,
    color: {
      type: String,
      default: '#3bb77e',
    },
    title: String,
  },
  methods: {
    handleClick() {
      // Emit custom event instead of showing alert directly
      this.$emit('click');
    }
  }
}
</script>

<style scoped>
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
</style>