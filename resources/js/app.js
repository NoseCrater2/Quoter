
require('./bootstrap');


import Vue from 'vue'
import vuetify from './plugins/vuetify'
import router from "./routes";
import VueRouter from "vue-router";
import App from "./components/Index";

window.Vue = require('vue');

Vue.use(VueRouter);

const app = new Vue({
    el: '#app',
    vuetify,
    router,
    components: {
        "index": App
    }
});


