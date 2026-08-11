import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/',
    name: 'home',
    component: () => import('./guest/HomeView.vue'),
  },
  {
    path: '/about',
    name: 'about',
    component: () => import('./guest/AboutView.vue'),
  },
  {
    path: '/login',
    name: 'login',
    component: () => import('../components/features/auth/LoginPage.vue'),
  },
  {
    path: '/admin/dashboard',
    name: 'admin-dashboard',
    component: () => import('./admin/DashboardView.vue'),
    meta: { requiresAuth: true },
  },
  {
    path: '/admin/users',
    name: 'admin-users',
    component: () => import('../components/features/users/IndexPage.vue'),
    meta: { requiresAuth: true },
  },
  {
    path: '/admin/users/create',
    name: 'admin-users-create',
    component: () => import('../components/features/users/FormPage.vue'),
    meta: { requiresAuth: true },
  },
  {
    path: '/admin/users/:id/edit',
    name: 'admin-users-edit',
    component: () => import('../components/features/users/FormPage.vue'),
    meta: { requiresAuth: true },
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

router.beforeEach((to, _from, next) => {
  if (to.meta.requiresAuth) {
    const token = document.cookie.includes('token=')
    if (!token) {
      next('/login')
      return
    }
  }
  next()
})

export default router
