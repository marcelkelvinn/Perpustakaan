import { createRouter, createWebHistory } from "vue-router";
import BukuList from "../components/BukuList.vue";
import PeminjamanList from "../components/PeminjamanList.vue";
import DendaList from "../components/DendaList.vue";
import SirkulasiList from "../components/SirkulasiList.vue";

const routes = [
  {
    path: "/bukus",
    name: "BukuList",
    component: BukuList,
  },
  {
    path: "/peminjamans",
    name: "PeminjamanList",
    component: PeminjamanList,
  },
  {
    path: "/dendas",
    name: "DendaList",
    component: DendaList,
  },
  {
    path: "/sirkulasis",
    name: "SirkulasiList",
    component: SirkulasiList,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
