import VueRouter from "vue-router";

const routes = [
    {
        path: "/",
        name: "Home",
        component: () => import("./views/Index/Home.vue")
    },
    
];

const router = new VueRouter({
    routes,
    mode: "history"
});

export default router;
