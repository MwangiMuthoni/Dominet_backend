
<template>
  <div>

<div class="navbar navbar-expand-lg navbar-dark bottom-nav fixed-top" id="bottom-nav">
  <router-link to="/home" class="navbar-brand" type="button" data-toggle="collapse" data-target="#navbarNavDropdown2" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation" @click="showCollapse = false"><img src="/img/logo.png" height="50px" alt="logo"></router-link>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown2" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation" @click="showCollapse = !showCollapse">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarNavDropdown2">
    <ul class="navbar-nav ms-auto navbarRight">
      <li class="nav-item dropdown" v-if="user!=null">
        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{user['name']}}</a>
        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
          <router-link to="/home" class="dropdown-item" type="button" data-toggle="collapse" data-target="#navbarNavDropdown2" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation" @click="showCollapse = false">Dashboard</router-link>
          <router-link to="/account" class="dropdown-item" type="button" data-toggle="collapse" data-target="#navbarNavDropdown2" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation" @click="showCollapse = false">Account</router-link>
          <router-link to="/profile" class="dropdown-item" type="button" data-toggle="collapse" data-target="#navbarNavDropdown2" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation" @click="showCollapse = false">Profile</router-link>
          <router-link to="/update-subscription" class="dropdown-item" v-if="parseInt(user?.company_subscription?.subscription_package_listings) <= parseInt(user?.company_subscription?.number_of_listings)" type="button" data-toggle="collapse" data-target="#navbarNavDropdown2" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation" @click="showCollapse = false">Update subscription</router-link>
          <a class="dropdown-item" @click.prevent="logout" style="cursor:pointer;">Logout</a>
        </div>
      </li>
      <li class="nav-item" v-else>
        <router-link to="/login" class="nav-link" data-toggle="collapse" data-target="#navbarNavDropdown2">Sign in</router-link>
      </li>
    </ul>
</div>
</div>
</div>
  </template>

<script>
    import Network from "../network-class";
    export default {
      name:'navbar',
        created(){
          this.$store.commit('getUser');
          this.$store.commit('getCompany');
        },
        mounted(){
        },
        destroyed () {
        },
        data:() => ({
            active: 'home',
            showCollapse:false,
        }),

        methods: { 
          logout:async function(){
                    var url='/api/logout';
                    const data = await Network.get(url);
                    localStorage.removeItem('token');
                    localStorage.removeItem('user');
                    localStorage.removeItem('auth');
                    this.$store.commit('getUser');
                    this.$router.push('/login');
          },
        },
        computed: {
          user() {
              return this.$store.state.user;
          },
          company() {
              return this.$store.state.company;
          },
          
        },
        props: {
            mobileMenu: {
              type: Array,
              required: false
            }
          },
        watch: {

        }
    }
</script>

