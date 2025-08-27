<template>
    <div>
      <div class="row letterfooter">
        <div class="col-sm-12 mt-5" v-if="company.companyBranding && company.companyBranding.footer">
           <img :src="company.companyBranding.footer" width="100%">
        </div>
      </div>
    </div>
</template>


  <script>
    export default {
    name:'letterfooter',
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