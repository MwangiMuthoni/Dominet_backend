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

        <div class="row mt-0">
          <p class="color-pink poppins-family number-text" style="font-weight: bold; color: red;">Expiry date: {{ expiryDate }}</p>
        </div>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      title: String,
      image: String,
      number: [String],
      linkName: String,
      expiryDate: String,
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
      animateCount(startValue, endValue) {
        const duration = 1000; 
        const start = performance.now();
        
        const animate = (time) => {
          let progress = (time - start) / duration;
          if (progress > 1) progress = 1; 

          const interpolatedValue = Math.floor(startValue + (endValue - startValue) * progress);
          this.animatedValue = interpolatedValue; 

          if (progress < 1) {
            requestAnimationFrame(animate);
          }
        };  

        requestAnimationFrame(animate);
    }
    },
    watch: {
    number(newValue, oldValue) {
      this.animateCount(oldValue, newValue);
    }
    },
  }
  </script>
  
  