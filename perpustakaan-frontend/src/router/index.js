import { createRouter, createWebHistory } from "vue-router";
import BukuList from "../components/BukuList.vue";

const routes = [
  {
    path: "/bukus",
    name: "BukuList",
    component: BukuList,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
