
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Vuetify from 'vuetify';

Vue.use(Vuetify);
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
// Vue.component('modal', require('./components/modal.vue').default);
// Vue.component('flash', require('./components/Flash.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import firebase from 'firebase/app';
import 'firebase/database';

var config = {
    apiKey: "AIzaSyBssSW5A5wd4ASz00-dTYXlp_hUwK2Xh7I",
    authDomain: "life-kanban.firebaseapp.com",
    databaseURL: "https://life-kanban.firebaseio.com",
    projectId: "life-kanban",
    storageBucket: "",
    messagingSenderId: "614730685038"
};


// DEV
// var config = {
//     apiKey: "AIzaSyCoZw6r41g2loEqhY3AdzRv221BhK1GVUk",
//     authDomain: "life-kanban-dev.firebaseapp.com",
//     databaseURL: "https://life-kanban-dev.firebaseio.com",
//     projectId: "life-kanban-dev",
//     storageBucket: "",
//     messagingSenderId: "465288829291"
// };


let fb = firebase.initializeApp(config);
Vue.prototype.$firebase = fb.database();

const app = new Vue({
    el: '#app',
});
