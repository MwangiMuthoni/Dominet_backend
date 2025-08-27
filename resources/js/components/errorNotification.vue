<template>
    <div class="center">
    </div>
</template>
 
<script>

  export default {
    name:'mobileTable',
    props: {
      error: '',
          },
    methods: {
        openNotification() {
          this.$vs.notification({
            position: 'bottom-right', 
            color: 'danger',
            duration:10000,
            title: this.error,
            text: 'If the problem persists, kindly contact support for assistance',
          })
        }
      },
    watch: {
      error(newValue){
        this.openNotification();
      }
    },
  };
</script>