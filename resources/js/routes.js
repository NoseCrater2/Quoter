
import Home from "./components/ExampleComponent";
import VueRouter from "vue-router";

const routes = [
    {
        path: "/",
        component: Home,
        name: "home"
    },
    
];

const router = new VueRouter({
    routes,
    mode: "history"
});

export default router;
