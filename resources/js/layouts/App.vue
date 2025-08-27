<template>
    <div> 
    <navbar></navbar>
    <sidebar class="only-desktop"></sidebar>
    <div class="cont">        
         <router-view> </router-view>
    </div>
     <defaultFooter></defaultFooter>
    </div>                   
</template>
 
<script>
    import sidebar from "../components/sidebar.vue";
    import navbar from "../components/navbar.vue";
    import defaultFooter from "../components/defaultFooter.vue";
   
    export default {
        name:'AppLayout',
        components: {sidebar,navbar, defaultFooter},
        data () {
            return {
                toggle: true
            }
        }
    }
</script>