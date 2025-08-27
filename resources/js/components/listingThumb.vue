<template>
    <router-link class="col-lg-3 col-md-4 col-sm-12 mb-4 thumb" :to="'/property/' + property.id+'?'+property.title">
        <div class="thumb-image" :style="`background-image: url('${property.image}');`"></div>
                <h5 class="card-title">{{ property.name }}</h5>
                <h6 class="card-text"><i class="fa-solid fa-location-dot"></i> {{ property.location }}</h6>
          </router-link>
</template>


<script>
    import Network from "../network-class";
    export default {
      name:'editor',
      props: {
        //   property:{type: Array,required: true},
        property:{type: Object,required: true},
              },
        created(){
            
        },
        methods: { 
          
        },
        watch: {
            
          },
    }
</script>