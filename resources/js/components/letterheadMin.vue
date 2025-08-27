<template>
    <div>
      <div class="row">
        <div class="col-sm-12 mb-5" v-if="company.companyBranding && company.companyBranding.logo">
           <img :src="company.companyBranding.logo" style="max-height: 150px; max-width: 100%; margin: auto; display: block;">
           <div style="text-align:center;">
              <h4 style="text-align:center; margin: 0px;">{{company.location}}</h4>
              <h4 style="text-align:center; margin: 0px;">{{company.phone}}</h4>
              <h4 style="text-align:center; margin: 0px;">{{company.email}}</h4>
           </div>
        </div>
      </div>
    </div>
</template>


  <script>
    export default {
    name:'letterhead',
    created(){
          this.$store.commit('getcompany');
        },
      methods: {
      },
      computed: {
          company() {
              return this.$store.state.company;
          },
        },
    }
  </script>