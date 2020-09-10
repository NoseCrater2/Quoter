
import Login from "./views/Index/Login";

import VueRouter from "vue-router";

const routes = [
    {
        path: "/",
        name: "Home",
        component: () => import("./views/Index/Home.vue")
    },
    {
        path: "/login",
        component: Login,
        name: "login"
    },
    
];

const router = new VueRouter({
    routes,
    mode: "history"
});

export default router;
