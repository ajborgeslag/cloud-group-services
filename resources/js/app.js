/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from "vue";

require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('login-component', require('./components/auth/login').default);
Vue.component('register-component', require('./components/auth/register').default);
Vue.component('manage-component', require('./components/back_officer/clients/manage').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import Vuetify from 'vuetify'
import VueRouter from 'vue-router';
import { routes } from './routes/routes';
Vue.use(Vuetify);
Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes
});

router.beforeEach((to, from, next) => {
    const authenticatedUser = localStorage.getItem('authenticatedUser');
    const requiresAuth = to.matched.some(record => record.meta.requiresAuth);

    if (requiresAuth && ! authenticatedUser)
    {
        console.log('akiiiiiiiiiii');
        next('/login')
    }
    else
        next();
});




const app = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
    router,
    data: {
        auth: localStorage.getItem('authenticatedUser'),
        clientes: [
            ['Gestionar Usuarios'],
            ['Adicionar Usuario'],
        ],
        servicios: [
            ['Gestionar Servicios'],
            ['Adicionar Servicio'],
        ],
        pedidos: [
            ['Gestionar Pedidos'],
            ['Adicionar Pedido'],
        ],
        proveedores: [
            ['Gestionar Proveedores'],
            ['Adicionar Proveedor'],
        ],
        coordinadores: [
            ['Gestionar Coordinadores'],
            ['Adicionar Coordinador'],
        ]
    }
});
