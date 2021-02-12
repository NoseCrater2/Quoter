import store from './store/store';
import Vue from 'vue'
import VueRouter from "vue-router";
Vue.use(VueRouter)


const routes = [
    {
        path: "/dashboard",
        component: () => import("./views/Index/Home"),
        name: "Dashboard",
        meta: {
            requiresAuth: true,
        },
        children: [
            {
                path: "quoter",
                redirect: {name: 'Quoter'}

            },
            {
                path: "users",
                component: () => import("./components/Users"),
                name: "Users",
                meta: {
                    requiresAuth: true,
                }

            },
            {
                path: "profile",
                component: () => import("./views/Profile"),
                name: "Profile",

            },

            {
                path: "stock/:slugProduct",
                component: () => import("./components/Stock"),
                name: "Stock",
                props: true,
                meta: {
                    requiresAuth: true,
                }

            },
            {
                path: "motorization",
                component: () => import("./components/ProductsTables/ImportMotorization"),
                name: "Motorization",
                meta: {
                    requiresAuth: true,
                }

            },
            {
                path: "galleries",
                component: () => import("./components/ProductsTables/ImportGalleries"),
                name: "Galleries",
                meta: {
                    requiresAuth: true,
                }

            },
            {
                path: "orders",
                component: () => import("./components/Orders"),
                name: "Orders",
                meta: {
                    requiresAuth: true,
                }

            },
            
        ]

    },
    {
        path: "/auth/login",
        component: () => import("./views/Index/Login"),
        name: 'login',

    },

    {
        path: "/",
        component: () => import("./views/Index/Index"),
        meta: { breadCrumb: 'Home' },
        children: [
            {
                path: "",
                component: () => import("./views/Index/Home2"),
                name: 'Home',
                meta: { breadCrumb: 'Home' },
            },
            {
                path: "compressor",
                component: () => import("./views/Compressor"),
                name: "Compressor",
            },
            {
                /* webpackChunkName: Aboutus*/
                path: 'aboutus',
                component: () => import("./views/Nosotros"),
                name: 'About us',


            },
            {
                path: 'client-register',
                component: () => import("./views/Register"),
                name: 'Register',
  
            },
            {
                /* webpackChunkName: Aboutus*/
                path: 'legal',
                component: () => import("./views/Legal"),
                name: 'Legal',
            },

            {
                path: "quoter",
                component: () => import("./components/Quoter"),
                name: "Quoter",

            },

            {
                path: 'contact',
                component: () => import("./views/Contact"),
                name: 'Contact',
            },

            {
                path: '/:slugProduct',
                component: () => import("./views/Categories"),
                name: 'Categories',
                props: true,
            },

            {
                path: '/:slugProduct/lineas/:slugType',
                component: () => import("./views/Lines"),
                name: 'Lines',
                props: true,
            },
            {
                path: '/:slugProduct/:slugType/tejidos/:slugLine',
                name: 'Tejidos',
                props: true,
                component: () => import("./views/Tejidos"),
            },
            {
                path: '/:slugProduct/:slugType/:slugLine?/:slugWeave?/detalles/:slugDetail',
                name: 'Details',
                component: () => import("./components/ProductDetail"),
                meta: {
                    name: 'Details'
                },
                props: true,
            },
            {
                path: '/:slugProduct/:slugType/:slugLine?/:slugWeave?',
                // alias: [
                //     '/:slugProduct/:slugType/tejido/:slugWave/:slugLine',
                //     '/:slugProduct/:slugType'
                // ],
                name: 'Products',
                component: () => import("./components/Products"),
                props: true,
                // children: [
                //     {
                //         path: '',
                //         
                //         props: true,
                //         component: () => import("./components/Products"),
                //     }
                // ]
            },
            

            
           
        ],
    },


    



   


    {
        path: "/signup",
        component: () => import("./views/Index/Signup"),
        name: "signup",


    },

    {
        path: "/404",
        alias: "*",
        name: 'notFound',
        component: () => import('./views/NotFound'),
    },


];

const router = new VueRouter({
    routes,
    mode: 'history',
    scrollBehavior (to, from, savedPosition){
        return {x:0, y:0}
    }
});



export default router;
