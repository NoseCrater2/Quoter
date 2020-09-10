require('./bootstrap');

import Vue from 'vue'
import vuetify from './plugins/vuetify'
import router from "./routes";
import VueRouter from "vue-router";


import Home from "./views/Index/Home";

import App from "./components/Index";
import Login from "./views/Index/Login";
import storeDefinition from "./store/store";
import Vuex from "vuex";



window.Vue = require('vue');

Vue.use(Vuex);
Vue.use(VueRouter);
const store = new Vuex.Store(storeDefinition);

const app = new Vue({
    el: '#app',
    vuetify,
    router,
    store,
    components: {

        Home,

        login: Login,
    }
});


