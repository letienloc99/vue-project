import { RouteRecordRaw, createRouter, createWebHistory } from "vue-router";
import admin from "./admin.tsx";

const auth = [
  {
    path: "/",
    component: () => import("../pages/login.vue"),
  },
];
const routes: Array<RouteRecordRaw> = [...admin, ...auth];

const router = createRouter({
  history: createWebHistory(),
  routes,
});
export default router;
