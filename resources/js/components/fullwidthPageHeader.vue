<template>
  <div>
    <div class="row page-header full-width-page-header">
      <div class="col-sm-7">
        <h3>{{ title }} {{ countdownTimer }}.</h3>
      </div>
      <div class="col-sm-5" style="text-align:right;">
        <router-link :to="'/make-payment'" class="btn btn-md" style="color: white !important;"><i class="fa fa-bell"></i>Subscribe now</router-link>
      </div>
    </div>
  </div>
</template>

  
<script>
export default {
  props: {
    title: [String, Number],
  },
  data() {
    return {
      countdownTimer: '',
    };
  },
  created() {
    this.$store.commit('getCompany');
    this.startCountdown();
  },
  computed: {
    company() {
      return this.$store.state.company;
    },
  },
  methods: {
    startCountdown() {
      const trialEndDate = new Date(this.company.trial_end_date).getTime();
      const updateCountdown = () => {
        const now = new Date().getTime();
        const distance = trialEndDate - now;

        if (distance < 0) {
          this.countdownTimer = 'Trial Expired';
          clearInterval(this.interval);
          return;
        }

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor(
          (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
        );
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        this.countdownTimer = `${days}d ${hours}h ${minutes}m ${seconds}s`;
      };

      this.interval = setInterval(updateCountdown, 1000);
    },
  },
  beforeDestroy() {
    clearInterval(this.interval);
  },
};
</script>

  
  <style>
  /* Your styles here */
  </style>
  