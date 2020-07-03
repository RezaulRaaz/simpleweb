require('./bootstrap');

window.Vue = require('vue');

// vue router
import VueRouter from 'vue-router'
Vue.use(VueRouter)

import {routes} from "./routes";
Vue.component('admin-main', require('./components/admin/AdminMaster').default);

const router = new VueRouter({
    routes,// short for `routes: routes`
    mode: 'history',
})


const app = new Vue({
    router,
    el: '#app',
});
