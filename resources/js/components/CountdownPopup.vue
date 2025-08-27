<template>
  <vs-dialog width="350px" not-center v-model="showPopup" v-on:close="handleClose">
        <template #header>
          <h4 class="not-margin">Are you still there?</h4>
        </template>
        <div class="con-content">
          <p>
           Your session will time out in {{ countdownTime }} seconds. Close this alert or open a new navigation route to keep using Afya dynamics
          </p>
        </div>
      </vs-dialog>
</template>

<script>
  import Network from "../network-class";

export default {
  name: 'CountdownPopup',
  data() {
    return {
      showPopup: false,
      countdownTime: 60,
      logoutTimer:null,
      popupTimer:null,
    };
  },
  mounted() {
  },
  mounted() {
    this.setupEventListeners();
    this.resetLogoutTimer();
  },
  beforeDestroy() {
    this.cleanupEventListeners();
  },
  methods: {
    handleClose() {
      this.showPopup=false;
      this.countdownTime=60;
    },
    setupEventListeners() {
      // document.addEventListener('mousemove', () => this.resetLogoutTimer());
      document.addEventListener('keydown', () => this.resetLogoutTimer());
      document.addEventListener('mousedown', () => this.resetLogoutTimer());
      document.addEventListener('touchstart', () => this.resetLogoutTimer());
    },
    cleanupEventListeners() {
      // document.removeEventListener('mousemove', this.resetLogoutTimer());
      document.removeEventListener('keydown', this.resetLogoutTimer());
      document.removeEventListener('mousedown', this.resetLogoutTimer());
      document.removeEventListener('touchstart', this.resetLogoutTimer());
    },
    logout:async function(){     
          var url='/api/logout';
          const data = await Network.get(url);
          localStorage.removeItem('token');
          localStorage.removeItem('user');
          localStorage.removeItem('auth');
          localStorage.removeItem('company');
          localStorage.removeItem('departments');
          this.$store.commit('getUser');
          this.$store.commit('getcompany');
          this.$store.commit('getDepartments');

          this.$router.push('/login');
    },
    resetLogoutTimer() {
      this.countdownTime =60;
      this.showPopup=false;
      if (this.logoutTimer) {clearTimeout(this.popupTimer); clearTimeout(this.logoutTimer);}
      this.popupTimer = setTimeout(() => {this.startCountdown(); this.showPopup=true;}, 540 * 1000);
      this.logoutTimer = setTimeout(() => {
        this.showPopup=false;
        const currentRoute = this.$router.currentRoute.fullPath;
        localStorage.setItem('lastRoute', currentRoute);
        this.logout();
        }, 600 * 1000);
    },
    startCountdown() {
      setInterval(() => {
        this.countdownTime--;
        if (this.countdownTime <= 0) {this.countdownTime =0;}
      }, 1000);
    },
  },
};
</script>