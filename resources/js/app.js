/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Vue from 'vue';
import axios from 'axios';
import VueAxios from 'vue-axios';
import VueMoment from 'vue-moment';


Vue.use(VueMoment);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */


Vue.component('app-component', require('./components/AppComponent.vue').default);
Vue.component('result-component', require('./components/ResultComponent.vue').default);
Vue.component('tasks-list', require('./components/tables/TaskstListComponent.vue').default);
Vue.component('tasks-results', require('./components/tables/TaskResultsComponent.vue').default);

import App from './components/AppComponent.vue';
import Result from './components/ResultComponent.vue';
import ResultList from './components/tables/TaskstListComponent.vue';
import TaskResults from './components/tables/TaskResultsComponent.vue';



window.axios = require('axios');
window.moment = require('vue-moment');

/**
 * Ajax config
 */

window.axios.defaults.headers.common = {
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    'X-Requested-With': 'XMLHttpRequest'
};

Vue.use(VueAxios, axios);

const app = new Vue({
    el: '#app',
    components: { App, Result, ResultList, TaskResults }
});
