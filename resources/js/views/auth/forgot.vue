<template>
    <div style="min-height: 100vh;">
        <div class="row justify-content-center" style="margin-top:50px;">
          <div class="col-sm-4">
            <img src="/public/img/logo.png" style="height: 70px; margin: auto; margin-bottom: 20px; display: block;">
            <div class="card login">
              <div class="card-body">
                <h3 class="mb-0" style="font-weight: 700;">Forgot you password?</h3> 
                <p class="mt-0">Provide your email address below.</p>
                <span class="plain-link" v-if="success"><i class="fa fa-check"></i> Your password reset request has been received successfully. Kindly check your email for reset link.</span>
                <form action="" method="POST" @submit.prevent="reset">
                  <div class="form-group mt-3">
                    <label>Email</label>
                    <input type="email" name="email" v-model="formData.email" class="form-control" required>
                    <div v-if="errors.email"><span class="text-danger" role="alert">{{errors.email[0]}}</span></div>
                  </div>
                  <button class="btn btn-sm btn-warning mt-2 mb-3 w-100" :disabled="loading_submit"> <span v-if="loading_submit"><i class="fas fa-circle-notch fa-spin"></i></span> {{loading_submit ? 'Loading..' : 'Request password reset'}}</button>
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
         
        },
        mounted(){
        },
      data:() => ({
        loading_submit:false,
        errors:[],
        formData:{
          email:'',
        },
        success:false,
      }),
      methods: {
        reset: async function (event) {
            this.loading_submit=true;
            var url='/api/reset';
            const data = await Network.store(url, this.formData);
            if(data.error){this.errors=data.error; this.loading_submit=false;}
            else{this.success=true; this.loading_submit=false;}
          },

         },
    };
    </script>