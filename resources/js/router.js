import Vue from 'vue';
import VueRouter from 'vue-router';
import AppLayout from './layouts/App.vue';
import GuestLayout from './layouts/Guest.vue';
import LandingLayout from './layouts/landing.vue';

import login from './views/auth/login.vue';
import forbiden from './views/auth/forbiden.vue';
import forgot from './views/auth/forgot.vue';
import reset from './views/auth/reset.vue';
import userRegister from './views/auth/register.vue';
import completeProfile from './views/auth/completeProfile.vue';
import confirmEmail from './views/auth/confirmEmail.vue';
import confirmPhone from './views/auth/confirmPhone.vue';
import confirmEmail2 from './views/auth/confirmEmail2.vue';
import confirmPhone2 from './views/auth/confirmPhone2.vue';
import changeEmail from './views/auth/changeEmail.vue';
import makePayment from './views/auth/makePayment.vue';
import changePhone from './views/auth/changePhone.vue';
import subscriptionPackage from './views/auth/subscriptionPackage.vue';
import updateSubscription from './views/auth/updateSubscription.vue';
import getStarted from './views/auth/getStarted.vue';
import createCompany from './views/auth/createCompany.vue';

import home from './views/auth/home.vue';

import companyIndex from './views/company/index.vue';
import companyCreate from './views/company/create.vue';
import companyShow from './views/company/show.vue';
import companyEdit from './views/company/edit.vue';

import packageIndex from './views/package/index.vue';
import packageCreate from './views/package/create.vue';
import packageShow from './views/package/show.vue';
import packageEdit from './views/package/edit.vue';

import subscriptionIndex from './views/subscription/index.vue';
import subscriptionCreate from './views/subscription/create.vue';
import subscriptionShow from './views/subscription/show.vue';
import subscriptionEdit from './views/subscription/edit.vue';

import userIndex from './views/user/index.vue';
import userCreate from './views/user/create.vue';
import userShow from './views/user/show.vue';
import userEdit from './views/user/edit.vue';

import billIndex from './views/bill/index.vue';
import billCreate from './views/bill/create.vue';
import billShow from './views/bill/show.vue';
import billEdit from './views/bill/edit.vue';

import paymentIndex from './views/payment/index.vue';
import paymentCreate from './views/payment/create.vue';
import paymentShow from './views/payment/show.vue';
import paymentEdit from './views/payment/edit.vue';

import profile from './views/profile/profile.vue';
import account from './views/account/account.vue';

import store from './app';



Vue.use(VueRouter);

if(localStorage.getItem('user') !='undefined'){var user=JSON.parse(localStorage.getItem('user'));}
else{var user=null;}

function refreshUser() {
    store.commit('getUser');
    user=JSON.parse(localStorage.getItem('user'));
}

function checkPermission(next, permission, blockFree) {
	refreshUser();
    if(user && user.permissions.includes(permission)){next();}else{next('/forbidden');}  
}

export default new VueRouter ({
    mode:"history",
    routes:[

        {component:LandingLayout, 
            path: '',
            children:[
                {path:'/', component: login},
            ] 
        },

    /*FrontEnd Routes*/
    {component:GuestLayout, 
            path: '',
            children:[
                {path:'/login/', component: login},
                {path:'/register/', component: userRegister},
                {path:'/complete-profile/', component: completeProfile},
                {path:'/confirm-email/', component: confirmEmail},
                {path:'/confirm-phone/', component: confirmPhone},
                {path:'/email-confirmation/', component: confirmEmail2},
                {path:'/phone-confirmation/', component: confirmPhone2},
                {path:'/change-email/', component: changeEmail},
                {path:'/change-phone/', component: changePhone},
                {path:'/make-payment', component: makePayment},
                {path:'/subscription-package/', component: subscriptionPackage},
                {path:'/forbiden/', component: forbiden},
                {path:'/forgot/', component: forgot},
                {path:'/password/reset/:token', component: reset},
                {path:'/get-started', component: getStarted},
                {path:'/update-subscription', component: updateSubscription},
                {path:'/create-company', component: createCompany},
                {path:'/profile',component:profile,},
                {path:'/account',component:account,},
            ] 
        },

    /*Admin Routes*/
    {component:AppLayout, 
        path: '',
        children:[
            {path:'/home', component: home},

            {path:'/company',component:companyIndex, async beforeEnter(to, from, next) {checkPermission(next, 'View company', false); }},
            {path:'/company/create', component:companyCreate, async beforeEnter(to, from, next) {checkPermission(next, 'Create company', false); }},
            {path:'/company/:id', component:companyShow, async beforeEnter(to, from, next) {checkPermission(next, 'View company', false); }},
            {path:'/company/:id/edit', component:companyEdit, async beforeEnter(to, from, next) {checkPermission(next, 'Edit company', false); }},

            {path:'/package',component:packageIndex, async beforeEnter(to, from, next) {checkPermission(next, 'View package', false); }},
            {path:'/package/create', component:packageCreate, async beforeEnter(to, from, next) {checkPermission(next, 'Create package', false); }},
            {path:'/package/:id', component:packageShow, async beforeEnter(to, from, next) {checkPermission(next, 'View package', false); }},
            {path:'/package/:id/edit', component:packageEdit, async beforeEnter(to, from, next) {checkPermission(next, 'Edit package', false); }},


            {path:'/subscription',component:subscriptionIndex, async beforeEnter(to, from, next) {checkPermission(next, 'View subscription', false); }},
            {path:'/subscription/create', component:subscriptionCreate, async beforeEnter(to, from, next) {checkPermission(next, 'Create subscription', false); }},
            {path:'/subscription/:id', component:subscriptionShow, async beforeEnter(to, from, next) {checkPermission(next, 'View subscription', false); }},
            {path:'/subscription/:id/edit', component:subscriptionEdit, async beforeEnter(to, from, next) {checkPermission(next, 'Edit subscription', false); }},

            {path:'/bill',component:billIndex, async beforeEnter(to, from, next) {checkPermission(next, 'View bill', false); }},
            {path:'/bill/create', component:billCreate, async beforeEnter(to, from, next) {checkPermission(next, 'Create bill', false); }},
            {path:'/bill/:id', component:billShow, async beforeEnter(to, from, next) {checkPermission(next, 'View bill', false); }},
            {path:'/bill/:id/edit', component:billEdit, async beforeEnter(to, from, next) {checkPermission(next, 'Edit bill', false); }},

            {path:'/payment',component:paymentIndex, async beforeEnter(to, from, next) {checkPermission(next, 'View payment', false); }},
            {path:'/payment/create', component:paymentCreate, async beforeEnter(to, from, next) {checkPermission(next, 'Create payment', false); }},
            {path:'/payment/:id', component:paymentShow, async beforeEnter(to, from, next) {checkPermission(next, 'View payment', false); }},
            {path:'/payment/:id/edit', component:paymentEdit, async beforeEnter(to, from, next) {checkPermission(next, 'Edit payment', false); }},

            {path:'/user',component:userIndex, async beforeEnter(to, from, next) {checkPermission(next, 'View user', false); }},
            {path:'/user/create', component:userCreate, async beforeEnter(to, from, next) {checkPermission(next, 'Create user', false); }},
            {path:'/user/:id', component:userShow, async beforeEnter(to, from, next) {checkPermission(next, 'View user', false); }},
            {path:'/user/:id/edit', component:userEdit, async beforeEnter(to, from, next) {checkPermission(next, 'Edit user', false); }},
], 
        async beforeEnter(to, from, next) {
            next();
            // if(user && user.role_id==1){next();}else{next('/forbiden');}
        }
    },
    
],
    scrollBehavior (to, from, savedPosition) {
    return { x: 0, y: 0 }
  }
});