
<<<<<<< HEAD
=======
import Login from "./views/Index/Login";

>>>>>>> master
import VueRouter from "vue-router";
import store from './store/loginModule';


const routes = [
   
    {
        path: "/",
<<<<<<< HEAD
        component: () => import("./views/Index/Home2"),
        name:'home'
        // name: "login",
        // beforeEnter(to, from, next) {
        //     if (store.getters.loggedIn()) {
        //         next({
        //         name: 'home',
        //         })
        //     } else {
        //          next()
        //     }
        // }
        
    },
    
    {
        path: '/aboutus',
        component: () => import("./views/Nosotros"),
        name: 'About us',
    },
    {
        path: '/contact',
        component: () => import("./views/Contact"),
        name: 'Contact',
    },
    {
        path: '/blinds/name/:name/id/:id',
        component: () => import("./views/Index/Curtains"),
        name: 'Blinds',
    },
    {
        path: '/curtains/name/:name/id/:id',
        component: () => import("./views/Index/Curtains"),
        name: 'Curtains',
    },
    {
        path: '/awnings/name/:name/id/:id',
        component: () => import("./components/Products"),
        name: 'Awnings',
    },
    {
        path: '/details/type/:type/product/:product_id',
        component: () => import("./components/ProductDetail"),
        name: 'Curtains',
    },
    {
        path: "/users",
        component: () => import("./components/Users"),
        name: "users",
        meta: {
            requiresAuth: true,
        }
       
    },

    {
        path: "/signup",
        component: () => import("./views/Index/Signup"),
        name: "signup",
       
=======
        name: "Home",
        component: () => import("./views/Index/Home.vue")
>>>>>>> master
    },
    {
        path: "/profile",
        component: () => import("./views/Profile"),
        name: "profile",
        meta: {
            requiresAuth: true,
        }
        
    },
    
];

const router = new VueRouter({
    routes,
    mode: "history"
});

export default router;
