import { createRouter, createWebHistory } from "vue-router";
import DashboardView from "../views/Dashboard.vue";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    linkActiveClass: "active",
    routes: [
        {
            path: "/",
            name: "dashboard",
            component: DashboardView,
        },
        {
            path: "/subscribers",
            name: "subscribers.index",
            component: () => import("../views/subscribers/Index.vue"),
        },
        {
            path: "/subscribers/create",
            name: "subscribers.create",
            component: () => import("../views/subscribers/Create.vue"),
        },
        {
            path: "/subscribers/:id/edit",
            name: "subscribers.edit",
            component: () => import("../views/subscribers/Edit.vue"),
        },
        {
            path: "/fields",
            name: "fields.index",
            component: () => import("../views/fields/Index.vue"),
        },
    ],
});

export default router;
