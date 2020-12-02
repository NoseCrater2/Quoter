require('./bootstrap');

import Vue from 'vue'
import store from "./store/store";
import router from "./router";

import vuetify from './plugins/vuetify'
import App from './App.vue';
import Stock from "./components/Stock";

// import Vuex from "vuex";

// Vue.use(Vuex);
// const store = new Vuex.Store(storeDefinition);

router.beforeEach((to, from, next) => {
  if(to.matched.some(record => record.meta.requiresAuth)){
   
      if (store.getters.loggedIn !== true) {
          next({
            name: 'login',
          })
        } else {
          next()
        }
  }else{
      next();
  }
});

window.Vue = require('vue');





const app = new Vue({
    el: '#app',
    vuetify,
    router,
    store,
    components: {
      App,
    // Index,
    Stock,
    // Quoter
    },

});


