require('./bootstrap');

import Vue from 'vue'
import vuetify from './plugins/vuetify'
import router from "./routes";
import VueRouter from "vue-router";


<<<<<<< HEAD

import Index from "./views/Index/Index";
import Stock from "./components/Stock";

=======
import Home from "./views/Index/Home";

import Login from "./views/Index/Login";
>>>>>>> master
import storeDefinition from "./store/store";
import Vuex from "vuex";



window.Vue = require('vue');

Vue.use(Vuex);
Vue.use(VueRouter);
const store = new Vuex.Store(storeDefinition);

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
       if (!store.getters.loggedIn) {
        next({
          name: 'login',
        })
      } else {
        next()
      }
    } else {
      next() // make sure to always call next()!
    }
  })

const app = new Vue({
    el: '#app',
    vuetify,
    router,
    store,
    components: {
<<<<<<< HEAD
    Index,
    Stock,
=======

        Home,

        login: Login,
>>>>>>> master
    }
});


