<template>
  <div class="app">
    <!-- Router View - This will display the current route component -->
    <RouterView />
  </div>
</template>

<script>
export default {
  name: 'App',
}
</script>

<style scoped>
.app {
  min-height: 100vh;
  font-family:
    'Poppins',
    -apple-system,
    BlinkMacSystemFont,
    sans-serif;
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}
</style>
