import store from './store/store';
import Vue from 'vue'
import VueRouter from "vue-router";
Vue.use(VueRouter)


const routes = [
   
    {
        path: "/",
        component: () => import("./views/Index/Index"),
        meta: {breadCrumb: 'Home'},
        children: [
            {
                path: "",
                component: () => import("./views/Index/Home2"),
                name: 'Home',
                meta: {breadCrumb: 'Home'},
            },
            {
                /* webpackChunkName: Aboutus*/
                path: 'aboutus',
                component: () => import("./views/Nosotros"),
                name: 'About us',
                meta: {hierarchy: 1},
               

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
                meta: {hierarchy: 1},
                
            },
        
            {
                path: 'contact',
                component: () => import("./views/Contact"),
                name: 'Contact',
                meta: {hierarchy: 1},
            },
            {
                path: 'tipos/:slugType',
                name: 'Categories',
                component: () => import("./views/Categories"),
                props: true,
                meta:{ name: 'Categories'},
                beforeEnter: (to, from, next) => {
                    const exists = store.state.productsModule.products.find(
                        product => product.slug === to.params.slugType
                    )

                    if(exists){
                        next();
                    }else{
                        next({name: 'notFound'})
                    }
                },
            },
            {
                path: 'lineas/:slugLine',
                name: 'Lines',
                props: true,
                meta:{ name: 'Lines'},
                component: () => import("./views/Lines"),
                  beforeEnter: (to, from, next) => {
                    const exists = store.state.productsModule.types.find(
                        type => type.slug === to.params.slugLine
                    )
                    if(exists){
                       next();
                    }else{
                        next({name: 'notFound'})
                    }
                },
            },

            {
                path: 'tejidos/:slugWeave',
                name: 'Tejidos',
                props: true,
                // meta:{ name: 'Tejidos'},
                component: () => import("./views/Tejidos"),
                //   beforeEnter: (to, from, next) => {
                //     const exists = store.state.productsModule.types.find(
                //         type => type.slug === to.params.slugLine
                //     )
                //     if(exists){
                //        next();
                //     }else{
                //         next({name: 'notFound'})
                //     }
                // },
            },
            {
                    path: 'catalogo/:slugModel',
                    name: 'Products',
                    component: () => import("./components/Products"),
                    meta:{name: 'Products'},
                    props: true,
                    beforeEnter: (to, from, next) => {
                      const existsInLines = store.state.productsModule.lines.find(
                          line => line.slug === to.params.slugModel
                      )

                      const existsInTypes = store.state.productsModule.types.find(
                        type => type.slug === to.params.slugModel
                    )

                    const existsInWeaves = store.state.productsModule.weaves.find(
                        weave => weave.slug === to.params.slugModel
                    )
                    

  
                      if(existsInLines || existsInTypes || existsInWeaves){
                          next();
                      }else{
                          next({name: 'notFound'})
                      }
                  },

                },


                  {
                    path: 'detalles/:slugDetail',
                    name: 'Details',
                    component: () => import("./components/ProductDetail"),
                    meta:{
                        name: 'Details'
                    },
                    props: true, 
                    //   beforeEnter: (to, from, next) => {
                    //     const exists = store.state.productsModule.variants.find(
                    //         variant => variant.slug === to.params.slugDetail
                    //     )
    
                    //     if(exists){
                    //         next();
                    //     }else{
                    //         next({name: 'notFound'})
                    //     }
                    // },
                },
                {
                    path: 'toldos/:slugDetail2',
                    name: 'SunblindDetails',
                    component: () => import("./components/SunblindDetail"),
                    meta:{
                        name: 'Details'
                    },
                    props: true, 
                    //   beforeEnter: (to, from, next) => {
                    //     const exists = store.state.productsModule.variants.find(
                    //         variant => variant.slug === to.params.slugDetail
                    //     )
    
                    //     if(exists){
                    //         next();
                    //     }else{
                    //         next({name: 'notFound'})
                    //     }
                    // },
                },
        ],
    },
                   
    
    {
         path: "/login",
         component: () => import("./views/Index/Login"),
         name:'login',
        beforeEnter(to, from, next) {
            if (store.getters.loggedIn) {
                next()
            } else {
                 next()
            }
        }
    },

    

    {
        path: "/dashboard",
        component: () => import("./views/Index/Home"),
        name: "Dashboard",
        meta: {
            requiresAuth: true,
        },
        children:[
            {
                path: "quoter",
                component: () => import("./components/Quoter"),
                name: "Quoter",
               
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
        path: "/signup",
        component: () => import("./views/Index/Signup"),
        name: "signup",
       
      
    },

    {
        path:"/404",
        alias: "*",
        name: 'notFound',
        component: () => import('./views/NotFound'),
    },
    
    
];

const router = new VueRouter({
    routes,
    mode: "history",
    linkActiveClass: 'is-active',
});



export default router;
