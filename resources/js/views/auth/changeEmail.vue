<template>
    <div class="row justify-content-center pt-4" style="min-height: 100vh;">
      <div class="col-sm-6 text-center" style="margin-top: 100px;">
        <form action="" method="POST" @submit.prevent="register">
            <div v-if="error!=null"><span class="text-danger" role="alert">{{error}}</span></div>
                <div class="form-group mt-3" style="display: flex; flex-direction: column; align-items: flex-start;">
                    <label style="padding: 10px 5px;">Email</label>
                    <input type="email" name="email" v-model="formData.email" placeholder="name@your-email.com"class="form-control" required>
                    <div v-if="errors.email"><span class="text-danger" role="alert">{{errors.email[0]}}</span></div>
                </div>

                <button class="btn btn-sm btn-warning mt-2 mb-3 w-100" :disabled="loading_submit">
                <span v-if="loading_submit"><i class="fas fa-circle-notch fa-spin"></i></span>
                {{loading_submit ? 'Loading..' : 'Change email'}}
                </button>

            <h5><router-link to="/confirm-email">Go back?</router-link></h5>

        </form>
      </div>
    </div>
</template>
  
<script>
    import axios from 'axios';
    import Network from "../../network-class";

    export default {
        name:'changeEmail',
        created(){
          this.getUser();
        },
        mounted(){
          const redirectRoute = window.localStorage.getItem('redirectRoute');
          if (redirectRoute) {
            this.$router.push(redirectRoute);
            window.localStorage.removeItem('redirectRoute');
          }
        },
      data:() => ({
        loading_submit:false,loading: false,
        error_message:false,
        errors:[],
        error:'',
        user:null,
        showPassword:false,
        hideForm: false,
        formData:{
          email:'',
        }
      }),
      methods: {
        register: async function (event) {
            this.loading_submit=true;
            var url='/api/change-email';
            const data = await Network.update(url, this.formData);
            if(data.error){this.errors=data.error; this.loading_submit=false;}
            else if(data.error_message){this.error_message=data.error_message; this.loading_submit=false;}
            else{
                this.loading_submit=true;
                localStorage.setItem("user", JSON.stringify(data.data));
                this.$router.push('/confirm-email')
            }
          },


          getUser(){
            var user=JSON.parse(localStorage.getItem('user'));
            this.user=user;
          },

          toggleShow() {
            this.showPassword = !this.showPassword;
          },


         },
    };
</script>