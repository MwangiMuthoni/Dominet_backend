<template>
    <div class="custom-component" @click="redirectToLink">
        <div class="row">
            <div class="col-sm-9">
                <h3>{{ title }}</h3>
            </div>
            <div class="col-sm-3">
                <img :src="image" alt="Image" class="image" />
            </div>
        </div>

        <div class="row mt-0">
          <h2 class="color-pink poppins-family number-text" style="font-weight: bold;">{{ number }}</h2>
        </div>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      title: String,
      image: String,
      number: [String, Number],
      linkName: String,
    },
    data() {
      return {
        animatedValue: this.value
      };
    },
    methods: {
      redirectToLink() {
        this.$router.push(this.linkName);
      },

    },
    watch: {

    },
  }
  </script>
  
  