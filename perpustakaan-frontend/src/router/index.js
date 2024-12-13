import { createRouter, createWebHistory } from 'vue-router';
import BukuList from "../components/BukuList.vue";
import HelloWorld from '../HelloWorld.vue';

const routes = [
  { path: '/', redirect: '/main' },
  { path: "/main", name: "HelloWorld", component: HelloWorld },
  { path: "/bukus", name: "BukuList", component: BukuList },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;