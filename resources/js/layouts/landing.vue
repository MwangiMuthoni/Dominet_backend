<template>
    <div>

     <navbar></navbar> 
    <div class="contClone">         
     <router-view> </router-view>                   
    </div>
    <defaultFooter></defaultFooter>
    <scrollToTop></scrollToTop>
    </div>
</template>
 
<script>
        import navbar from "../components/navbar.vue";
        import defaultFooter from "../components/defaultFooter.vue";
        import scrollToTop from '../components/scrollToTop.vue';
    export default {
        name:'LandingLayout',
        components: {navbar, defaultFooter, defaultFooter, scrollToTop},
        data () {
            return {
                toggle: true
            }
        },
        methods: {
            
        }
    }
</script>

