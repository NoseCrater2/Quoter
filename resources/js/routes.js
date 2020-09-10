
import Home from "./components/ExampleComponent";
import Login from "./views/Index/Login";
import VueRouter from "vue-router";

const routes = [
    {
        path: "/",
        component: Home,
        name: "home"
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
