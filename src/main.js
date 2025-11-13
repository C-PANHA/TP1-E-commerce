// import './assets/base.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'

const app = createApp(App)

app.use(createPinia())
app.use(router)

// Global error handler
app.config.errorHandler = (err, instance, info) => {
  console.error('Global error:', err)
  console.error('Component instance:', instance)
  console.error('Error info:', info)

  // Handle different types of errors
  if (err.message && err.message.includes('Network Error')) {
    console.warn('Network error detected - check backend connectivity')
  } else if (err.message && err.message.includes('404')) {
    console.warn('API endpoint not found - check backend routes')
  }

  // You can also send error to a logging service here
  // Example: sendErrorToService(err, instance, info)
}

app.mount('#app')
