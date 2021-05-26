require('./bootstrap');

import Vue from 'vue'
import store from "./store/store";
import router from "./router";

import vuetify from './plugins/vuetify'
import App from './App.vue';

// import Vuex from "vuex";

// Vue.use(Vuex);
// const store = new Vuex.Store(storeDefinition);

// router.beforeEach((to, from, next) => {
//   if(to.matched.some(record => record.meta.requiresAuth)){
//       if (store.state.isLoggedIn === true) {
//           next()
//         } else {
//           next({
//             name: 'login',
//           })
//         }
//   }else{
//       next();
//   }
// });



window.Vue = require('vue');
window.axios.interceptors.response.use(
  response => {
    return response
  }, 
  error => {
    if(401 === error.response.status){
      store.dispatch("logout")
    }
    return Promise.reject(error)
  }
)





const app = new Vue({
    el: '#app',
    vuetify,
    router,
    store,
    components: {
      App,
    },
    async beforeCreate() {
      this.$store.dispatch("loadStoredState");
      this.$store.dispatch("loadUser")
  },

});


