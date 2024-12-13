import { createRouter, createWebHistory } from 'vue-router';
import HelloWorld from '../views/HelloWorld.vue';
import Home from '../views/Home.vue';
import Login from '../views/Auth/Login.vue';
import Register from '../views/Auth/Register.vue';
import Buku from '../views/Buku/Buku.vue';
import Peminjaman from '../views/Peminjaman/Peminjaman.vue';
import Denda from '../views/Denda/Denda.vue';
import Sirkulasi from '../views/Sirkulasi/Sirkulasi.vue';

const routes = [
  { path: '/', name: "Home", component: Home, meta: { requiresAuth: true } },
  { path: "/hw", name: "HelloWorld", component: HelloWorld },
  { path: "/login", name: "Login", component: Login },
  { path: "/register", name: "Register", component: Register },
  { path: "/buku", name: "Buku", component: Buku, meta: { requiresAuth: true } },
  { path: "/denda", name: "Denda", component: Denda, meta: { requiresAuth: true } },
  { path: "/peminjaman", name: "Peminjaman", component: Peminjaman, meta: { requiresAuth: true } },
  { path: "/sirkulasi", name: "Sirkulasi", component: Sirkulasi, meta: { requiresAuth: true } },
  
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('auth_token');
  
  if (to.meta.requiresAuth && !token) {
    next('/login');
  } else {
    next();
  }
});

export default router;