import { createRouter, createWebHistory } from "vue-router";
import BukuList from "../components/BukuList.vue";
import BukuDisplay from "../components/BukuDisplay.vue";

const routes = [
  {
    path: "/bukus",
    name: "BukuList",
    component: BukuList,
  },
  {
    path: "/displaybukus",
    name: "BukuDisplay",
    component: BukuDisplay,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
