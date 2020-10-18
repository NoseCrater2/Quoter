
import VueRouter from "vue-router";
import store from './store/loginModule';


const routes = [
   
    {
        path: "/",
        component: () => import("./views/Index/Login"),
        name: "login",
        beforeEnter(to, from, next) {
            if (store.getters.loggedIn()) {
                next({
                name: 'home',
                })
            } else {
                 next()
            }
        }
        
    },
    
    {
        path: '/home',
        component: () => import("./views/Index/Home"),
        name: 'home',
        meta: {
            requiresAuth: true,
        }

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
