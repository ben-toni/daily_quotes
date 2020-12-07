/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// Vue
window.Vue = require('vue');

// Constants
import constants from "./constants";
window.constants = constants;
Vue.prototype.$constants = constants;


// Moment
const moment = require('moment');
Vue.use(require('vue-moment'), {
    moment
});

// Vue toastr
import VueToastr2 from 'vue-toastr-2';
import 'vue-toastr-2/dist/vue-toastr-2.min.css';
window.toastr = require('toastr');
Vue.use(VueToastr2, {
    progressBar: true,
    positionClass: "toast-bottom-right"
});

// Import lang
import Lang from 'lang.js';
// Setup
const default_locale = window.default_language;
const fallback_locale = window.fallback_locale;
const messages = window.messages;

Vue.prototype.trans = new Lang( { messages, locale: default_locale, fallback: fallback_locale } );

Vue.prototype.returnObject = function(key) {
    var splittedKeys = key.split('.');
    var nestedObject = this.trans.messages[this.trans.getLocale()];
    splittedKeys.forEach((item) => {
        nestedObject = nestedObject[item];
    });
    return nestedObject;
};

Vue.prototype.translate = function(key) {
    var translation = this.returnObject(key);
    return translation;

};

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

/**
 * Pages
 */
// Landing
Vue.component('landing-page', require('./pages/landing/landing-page').default);
// Quotes
Vue.component('quotes-index', require('./pages/admin/quotes/index').default);
// Users
Vue.component('users-index', require('./pages/admin/users/index').default);
/**
 * Components
 */
// Pagination
Vue.component('custom-pagination', require('./components/paginations/pagination').default);
// Modals
Vue.component('create-quote-modal', require('./components/modals/quote/create-quote-modal').default);
Vue.component('delete-modal', require('./components/modals/quote/delete-modal').default);
Vue.component('show-quote-modal', require('./components/modals/quote/show-quote-modal').default);
Vue.component('update-quote-modal', require('./components/modals/quote/update-quote-modal').default);
Vue.component('change-subscriber-status', require('./components/modals/subsriber/change-subscriber-status').default);
Vue.component('change-status-mail', require('./components/modals/subsriber/change-status-mail').default);
Vue.component('payment-modal', require('./components/modals/subsriber/payment-modal').default);

// Interceptor for toastr messages
window.axios.interceptors.response.use(function (response) {
    // Success response
    return response;
}, function (error) {
    // Do something with response error
    // If error is 422
    if (error.response.status == 422) {
        Object.keys(error.response.data.message).forEach(key => {
            let errorMessage = error.response.data.message[key];
            app.$toastr.error(errorMessage);
        })

    } else {
        // Other errors
        app.$toastr.error(error.response.message);
    }

    return Promise.reject(error.response);
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
