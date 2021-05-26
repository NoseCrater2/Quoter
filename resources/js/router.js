import store from './store/store';
import Vue from 'vue'
import VueRouter from "vue-router";
Vue.use(VueRouter)


const routes = [
    {
        
        path: "/dashboard",
        component: () => import('./views/Index/Home.vue'),
        name: "Dashboard",
        meta: {
            requiresAuth: true,
        },
        children: [
            {
                path: "quoting",
                component: () => import("./components/Quoter.vue"),

            },
            {
                path: "users",
                component: () => import("./components/Users.vue"),
                name: "Users",
                meta: {
                    requiresAuth: true,
                }

            },
            {
                path: "profile",
                component: () => import("./views/Profile.vue"),
                name: "Profile",

            },

            {
                path: "orders",
                component: () => import("./views/Users/Orders.vue"),
                name: "Orders",

            },

            {
                path: "stock/:slugProduct",
                component: () => import("./components/Stock.vue"),
                name: "Stock",
                props: true,
                meta: {
                    requiresAuth: true,
                }

            },
            {
                path: "motorization",
                component: () => import("./components/ProductsTables/ImportMotorization.vue"),
                name: "Motorization",
                meta: {
                    requiresAuth: true,
                }

            },
            {
                path: "galleries",
                component: () => import("./components/ProductsTables/ImportGalleries.vue"),
                name: "Galleries",
                meta: {
                    requiresAuth: true,
                }

            },
            {
                path: "orders",
                component: () => import("./components/Orders.vue"),
                name: "Orders",
                meta: {
                    requiresAuth: true,
                }

            },
            
        ]

    },
    {
        path: "/pdf-preview",
        name: 'PreviewPDF',
        component: () => import('./views/PreviewPDF.vue'),
    },
    {
        path: "/auth/login",
        component: () => import("./views/Index/Login.vue"),
        name: 'login',

    },

    {
        path: "/",
        component: () => import("./views/Index/Index.vue"),
        meta: { breadCrumb: 'Home' },
        children: [
            {
                path: "",
                component: () => import("./views/Index/Home2.vue"),
                name: 'Home',
                meta: { breadCrumb: 'Home' },
            },
            {
                path: "compressor",
                component: () => import("./views/Compressor.vue"),
                name: "Compressor",
            },
            {
                /* webpackChunkName: Aboutus*/
                path: 'aboutus',
                component: () => import("./views/Nosotros.vue"),
                name: 'About us',


            },
            {
                path: 'client-register',
                component: () => import("./views/Register.vue"),
                name: 'Register',
  
            },
            {
                /* webpackChunkName: Aboutus*/
                path: 'legal',
                component: () => import("./views/Legal.vue"),
                name: 'Legal',
            },

            {
                path: "quoter",
                component: () => import("./components/Quoter.vue"),
                name: "Quoter",

            },

            {
                path: 'contact',
                component: () => import("./views/Contact.vue"),
                name: 'Contact',
            },
            {
                path: 'motorized',
                component: () => import("./views/Motorized.vue"),
                name: 'Motorized',
            },
            {
                path: '/:slugProduct',
                component: () => import("./views/Categories.vue"),
                name: 'Categories',
                props: true,
            },

            {
                path: '/:slugProduct/lineas/:slugType',
                component: () => import("./views/Lines.vue"),
                name: 'Lines',
                props: true,
            },
            {
                path: '/:slugProduct/:slugType/galleries',
                component: () => import("./views/Galleries.vue"),
                name: 'Gallery',
                props: true,
            },
            {
                path: '/:slugProduct/:slugType/tejidos/:slugLine',
                name: 'Tejidos',
                props: true,
                component: () => import("./views/Tejidos.vue"),
            },
            {
                path: '/:slugProduct/:slugType/:slugLine?/:slugWeave?/detalles/:slugDetail',
                name: 'Details',
                component: () => import("./components/ProductDetail.vue"),
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
                component: () => import("./components/Products.vue"),
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
        path: "/404",
        alias: "*",
        name: 'notFound',
        component: () => import('./views/NotFound.vue'),
    },


];

const router = new VueRouter({
    routes,
    mode: 'history',
    scrollBehavior (to, from, savedPosition){
        return {x:0, y:0}
    }
});

router.beforeEach((to, from, next) => {
    if(to.matched.some(record => record.meta.requiresAuth)){
        if(store.state.isLoggedIn == 'false' || store.state.isLoggedIn == false){
            next({
                name: 'login',
                query: {redirect: to.fullPath}
            })
        }else{
            next()
        }
    }else{
        next();
    }
})



export default router;
