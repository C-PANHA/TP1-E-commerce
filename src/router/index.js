import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      name: 'welcome',
      path: '/',
      component: () => import('../views/WelcomeView.vue'),
    },
  ],
})

export default router
