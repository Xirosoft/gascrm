/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

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

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('lead-form', require('./components/Lead/LeadForm.vue').default);
Vue.component('lead-details', require('./components/Lead/LeadDetails.vue').default);

Vue.component('account-form', require('./components/Account/AccountForm.vue').default);
Vue.component('account-details', require('./components/Account/AccountDetails.vue').default);

Vue.component('contact-form', require('./components/Contact/ContactForm.vue').default);
Vue.component('contact-details', require('./components/Contact/ContactDetails.vue').default);

Vue.component('task-form', require('./components/Task/TaskForm.vue').default);
Vue.component('task-details', require('./components/Task/TaskDetails.vue').default);

Vue.component('event-form', require('./components/Event/EventForm.vue').default);
Vue.component('event-details', require('./components/Event/EventDetails.vue').default);

import { Lang } from 'laravel-vue-lang';

// Register the plugin
Vue.use(Lang, {
	locale: 'bn',
	fallback: 'en',
	ignore: {
		bn: ['validation'],
	},
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
