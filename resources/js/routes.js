
import VueRouter from "vue-router";

const routes = [
    {
        path: "/",
        component: () => import("./components/Quoter"),
        name: "quoter"
    },
    {
        path: "/login",
        component: () => import("./views/Index/Login"),
        name: "login"
    },
    {
        path: "/users",
        component: () => import("./components/Users"),
        name: "users"
    },

    {
        path: "/signup",
        component: () => import("./views/Index/Signup"),
        name: "signup"
    },
    {
        path: "/profile",
        component: () => import("./views/Profile"),
        name: "profile"
    },
    
];

const router = new VueRouter({
    routes,
    mode: "history"
});

export default router;
