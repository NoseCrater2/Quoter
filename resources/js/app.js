require('./bootstrap');

import Vue from 'vue'
import store from "./store/store";
import router from "./router";

import vuetify from './plugins/vuetify'
import App from './App.vue';

import { LMap, LTileLayer, LMarker } from 'vue2-leaflet';
import "leaflet/dist/leaflet.css";


Vue.component('l-map', LMap);
Vue.component('l-tile-layer', LTileLayer);
Vue.component('l-marker', LMarker);
L.Icon.Default.mergeOptions({
   iconRetinaUrl: require('leaflet/dist/images/marker-icon-2x.png'),
   iconUrl: require('leaflet/dist/images/marker-icon.png'),
   shadowUrl: require('leaflet/dist/images/marker-shadow.png'),
});

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





