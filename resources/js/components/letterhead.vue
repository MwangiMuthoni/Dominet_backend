<template>
    <div>
      <div class="row">
        <div class="col-sm-12 mb-5" v-if="company.companyBranding && company.companyBranding.letter_head">
           <img :src="company.companyBranding.letter_head" width="100%">
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