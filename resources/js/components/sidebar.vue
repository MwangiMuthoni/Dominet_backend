<template>
  <div class="hidden">
    <vs-sidebar
      v-model="active"
      background="#134C41"
      style="z-index: 980 !important; color: white !important;"
      hover-expand
      open
      notShadow
      fixed
      :reduce="reduceValue"
    >
      <vs-sidebar-item
        id="dash"
        to="/home"
        style="margin-top: 100px; color: white !important;"
      >
        <template #icon>
          <i class="fa-solid fa-house"></i>
        </template>
        Home
      </vs-sidebar-item>

      <vs-sidebar-item
        id="company"
        to="/company"
        class="only-desktop"
        v-if="user.permissions.includes('View company')"
        style="color: white !important;"
      >
        <template #icon>
          <i class="fa-solid fa-building-columns"></i>
        </template>
        Companies
      </vs-sidebar-item>
      
      
      <vs-sidebar-item
        id="package"
        to="/package"
        v-if="user.permissions.includes('View package') && user.role_id == 1"
        style="color: white !important;"
      >
        <template #icon>
          <i class="fa-solid fa-box"></i>
        </template>
        Packages
      </vs-sidebar-item>
      
      <vs-sidebar-item
        id="subscription"
        to="/subscription"
        v-if="user.permissions.includes('View subscription') && user.role_id == 1"
        style="color: white !important;"
      >
        <template #icon>
          <i class="fa-solid fa-calendar-check"></i>
        </template>
        Subscriptions
      </vs-sidebar-item>



      <vs-sidebar-item
        id="users"
        to="/user"
        class="only-mob"
        style="color: white !important;"
      >
        <template #icon>
          <i class="fas fa-user"></i>
        </template>
        Users
      </vs-sidebar-item>


      <vs-sidebar-item
        id="bills"
        to="/bill"
        v-if="user.permissions.includes('View bill') && user.role_id == 1"
        style="color: white !important;"
      >
        <template #icon>
          <i class="fas fa-file-invoice"></i>
        </template>
        Bills
      </vs-sidebar-item>

      <vs-sidebar-item
        id="payments"
        to="/payment"
        v-if="user.permissions.includes('View payment') && user.role_id == 1"
        style="color: white !important;"
      >
        <template #icon>
          <i class="fas fa-credit-card"></i>
        </template>
        Payments
      </vs-sidebar-item>




      <vs-sidebar-item style="color: white !important;">
        <template #icon>
          <button @click="logout"  style="background: none; border: none; color: white !important;">
            <i class="fa fa-sign-out" aria-hidden="true"></i>
          </button>
        </template>
        <button style="background: none; border: none; color: white !important;" @click="logout">
          Logout
        </button>
      </vs-sidebar-item>

    </vs-sidebar>
  </div>
</template>

<script>
  import Network from "../network-class";
export default {
  created() {
    this.getUser();
  },
  data() {
    return {
      active: 'home',
      user: null,
      moreProperty: false,
      moreSetting: false,
      reduceValue: true,
    };
  },
  methods: {
    getUser() {
      this.user = JSON.parse(localStorage.getItem('user'));
    },
    showMoreProperty() {
      this.moreProperty = !this.moreProperty;
    },
    showMoreSetting() {
      this.moreSetting = !this.moreSetting;
    },
    toggleTab(tab) {
      this.active = tab;
    },
    logout:async function(){
      var url='/api/logout';
      const data = await Network.get(url);
      localStorage.removeItem('token');
      localStorage.removeItem('user');
      localStorage.removeItem('auth');
      this.$store.commit('getUser');
      this.$router.push('/login');
    },
  },
};
</script>

