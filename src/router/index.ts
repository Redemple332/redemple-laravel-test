import { createRouter, createWebHistory, RouteRecordRaw } from "vue-router";
import PageNotFound from "@/views/PageNotFound.vue";
import LandingPage from "@/views/LandingPage.vue";
import Users from "@/views/User/User.vue";
import BaseContainer from "@/components/BaseContainer.vue";
const routes: Array<RouteRecordRaw> = [
    {
        path: "/login",
        name: "Login",
        component: () => import("@/views/auth/Login.vue"),
    },
    {
        path: "/register",
        name: "Register",
        component: () => import("@/views/auth/Register.vue"),
    },

    {
        path: "/:pathMatch(.*)*",
        name: "NotFound",
        component: PageNotFound,
    },
    {
        path: "/",
        redirect: "/",
        name: "home",
        component: BaseContainer,
        children: [
            {
                path: "/users",
                name: "Users List",
                component: Users,
            },
            {
                path: "/",
                name: "LandingPage",
                component: LandingPage,
            },
        ],
    },
];

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes,
});

export default router;
