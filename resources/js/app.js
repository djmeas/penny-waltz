
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Components
 */
Vue.component('transactions-page', require('./components/transactions/transactions-page.vue').default);
Vue.component('transactions-add', require('./components/transactions/transactions-add.vue').default); 

/**
 * Global / Prototype
 */
Vue.prototype.$baseURL = window.location.origin;
Vue.prototype.$baseAPI = window.location.origin + '/api';

Vue.prototype.$apiRoutes = {
	"userTransactionCategories": {
		title: "User Transaction Categories",
		url: Vue.prototype.$baseAPI + '/transactions/user_categories'
	}
};

Vue.prototype.$transactionTypeList = [
	{
		title: 'Money In',
		value: 1
	},
	{
		title: 'Money Out',
		value: -1
	}
];

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});