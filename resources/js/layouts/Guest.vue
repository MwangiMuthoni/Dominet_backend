<template>
    <div>

     <navbar></navbar> 
    <div class="cont-full">         
     <router-view> </router-view>                   
    </div>
    <defaultFooter></defaultFooter>
    </div>
</template>
 
<script>
        import navbar from "../components/navbar.vue";
        import defaultFooter from "../components/defaultFooter.vue";

    export default {
        name:'GuestLayout',
        components: {navbar, defaultFooter},
        data () {
            return {
                toggle: true
            }
        },
        methods: {
            
        }
    }
</script>