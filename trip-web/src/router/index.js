import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '@/views/LoginView.vue'
import RegisterView from '@/views/RegisterView.vue'
import DashboardView from '@/views/DashboardView.vue'
import TripCreateView from '@/views/TripCreateView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/', redirect: '/login' },
    { path: '/login', name: 'login', component: LoginView },
    { path: '/register', name: 'register', component: RegisterView },
    { path: '/dashboard', name: 'dashboard', component: DashboardView },
    { path: '/create-trip', name: 'create-trip', component: TripCreateView },
    {
      path: '/dashboard/trip/:id',
      name: 'trip-details',
      component: () => import('../views/TripDetailsView.vue'),
      props: true
    },

  ],
})

export default router