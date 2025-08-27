/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
 
import '../css/app.css';
// window.Vue = require('vue').default;
// 
import App from './App.vue';
import VueAxios from 'vue-axios';
import Vue from 'vue';
import Vuex from 'vuex';
import VueRouter from 'vue-router';
import axios from 'axios';
import router from './router';
import Vuesax from 'vuesax'
import BootstrapVue from 'bootstrap-vue'
import 'vuesax/dist/vuesax.css' //Vuesax 

import { Vue2TinymceEditor } from "vue2-tinymce-editor";
Vue.component('vue2-tinymce-editor', Vue2TinymceEditor);
import Editor from "./components/editor.vue";
Vue.component('editor', Editor);


Vue.use(BootstrapVue)
Vue.use(Vuesax, {
    colors: {
      primary:'#FA8729',
      success:'rgb(23, 201, 100)',
      danger:'rgb(242, 19, 93)',
      warning:'#FA8729',
      dark:'rgb(36, 33, 69)'
    }
});

import Loading from "./components/loading.vue";
Vue.component('loading-message', Loading);

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
const options = {
  confirmButtonColor: '#dc3545',
  cancelButtonColor: '#8b2aaf',
  title: 'Are you sure?',
  text: 'You won\'t be able to revert this!',
  showCancelButton: true,
  confirmButtonText: 'Yes, delete it!',
  customClass: {
            title: 'custom-swal-title',
            content: 'custom-swal-content',
            confirmButton: 'custom-swal-confirm-button',
            cancelButton: 'custom-swal-cancel-button'
        }
};
Vue.use(VueSweetalert2,options);

import ComponentLoader from "./components/componentLoader.vue";
Vue.component('component-loader', ComponentLoader);

import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
Vue.component('font-awesome-icon', FontAwesomeIcon);

import '@fortawesome/fontawesome-free/css/all.css';
import '@fortawesome/fontawesome-free/js/all.js';

Vue.component('pagination', require('laravel-vue-pagination'));
Vue.config.productionTip = false;


Vue.use(Vuex);

const store = new Vuex.Store({
  state: {
    user: [],
    company: []
  },
  mutations: {
    getUser(state) {
      var user = JSON.parse(localStorage.getItem('user'));
      state.user = user;
      console.log(user);
    },
    getCompany(state) {
      var company = JSON.parse(localStorage.getItem('company'));
      state.company = company;
    }
  }
});

Vue.use(VueRouter);
Vue.use(VueAxios, axios);

import VueApexCharts from 'vue-apexcharts';

Vue.component('apexchart', VueApexCharts);

export default store;

new Vue({
    el: '#app',
    router: router,
    render: h => h(App),
    store: store,
});

