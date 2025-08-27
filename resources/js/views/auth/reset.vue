<template>
    <div class="pt-4" style="min-height: 100vh;">
        <div class="row justify-content-center" style="margin-top:100px;">
          <div class="col-sm-4">
            <div class="card login">
              <div class="card-body">
                <h3 class="mb-0">Reset your password?</h3> 
                <h5 class="mt-0">Provide a new password below.</h5>
                <span class="plain-link" v-if="success"><i class="fa fa-check"></i> Your password reset request has been received successfully. Kindly check your email for reset link.</span>
                <form action="" method="POST" @submit.prevent="reset">
                 <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" v-model="formData.password" class="form-control" required>
                    <div v-if="errors.password"><span class="text-danger" role="alert">{{errors.password[0]}}</span></div>
                  </div>
                  <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" v-model="formData.password_confirmation" class="form-control" required>
                    <div v-if="errors.password_confirmation"><span class="text-danger" role="alert">{{errors.password_confirmation[0]}}</span></div>
                  </div>
                  <button class="btn btn-sm btn-warning mt-2 mb-3 w-100" :disabled="loading_submit"> <span v-if="loading_submit"><i class="fas fa-circle-notch fa-spin"></i></span> {{loading_submit ? 'Loading..' : 'Reset Password'}}</button>
                </form>
              </div>
            </div>
          </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import Network from "../../network-class";

    export default {
        name:'login',
        components: {},
        created(){
         this.formData.token=this.$route.params.token;
         this.formData.email=this.$route.query.email;
         this.$store.commit('getUser');
          if(this.user!=null){
            this.$router.push('/home');
          }
        },
        mounted(){
        },
      data:() => ({
        loading_submit:false,
        errors:[],
        formData:{
          email:'',
          password:'',
          password_confirmation:'',
          token:'',
        },
        success:false,
      }),
      methods: {
        reset: async function (event) {
            this.loading_submit=true;
            var url='/api/reset/save';
            const data = await Network.store(url, this.formData);
            if(data.error){this.errors=data.error; this.loading_submit=false;}
            else{
              this.loading_submit=false;
              localStorage.setItem("auth", true);
              localStorage.setItem("user", JSON.stringify(data.user));
              localStorage.setItem("token", data.token.plainTextToken);
              this.$store.commit('getUser');
              
              if(parseInt(this.user.role_id) === 1){
                this.$router.push('/home');
              }
              if(parseInt(this.user.role_id) === 2 || parseInt(this.user.role_id) === 3){
                this.$router.push('/company-dash');
              }
              if(parseInt(this.user.role_id) !== 1 && parseInt(this.user.role_id) !== 2 && parseInt(this.user.role_id) !== 3){
                this.$router.push('/user-dash');
              }
            }
          },

         },
      computed: {
          user() {
              return this.$store.state.user;
          }
        },
    };
    </script>