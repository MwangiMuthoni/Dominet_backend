<template>
    <div></div>
</template>


  <script>
    export default {
    created(){
          this.openNotification();
        },
    updated(){
          this.openNotification();
        },
      methods: {
        openNotification(position = 'top-center',color = 'danger', duration=6000) {
          const noti = this.$vs.notification({
            duration,
          	color,
            position,
            progress: 'auto',
            title: 'Error 500',
            text: 'Ooops!. Something went wrong. Kindly contact the site administrator if problem persists.'
          })
        }
      }
    }
  </script>