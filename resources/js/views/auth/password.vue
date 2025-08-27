<template>
    <div>
        <div class="row">
            <div class="col-sm-5">  
    <template>
     <div class="card">
      <div class="card-body">
          <h4 class="not-margin">Change password</h4>
          <form action="#" @submit.prevent="update">
            <div class="form-group">
              <label>Current Password</label>
              <input type="password" class="form-control" name="current_password" v-model="formData.current_password">
              <div v-if="errors.current_password"><span class="text-danger" role="alert">{{errors.current_password[0]}}</span></div>
            </div>

            <div class="form-group col">
              <label>New Password</label>
              <input type="password" name="password" v-model="formData.password" class="form-control">
              <div v-if="errors.password"><span class="text-danger" role="alert">{{errors.password[0]}}</span></div>
            </div>

            <div class="form-group col">
              <label>Confirm Password</label>
              <input type="password" name="password_confirmation" v-model="formData.password_confirmation" class="form-control">
              <div v-if="errors.password_confirmation"><span class="text-danger" role="alert">{{errors.password_confirmation[0]}}</span></div>
            </div>
            <button class="btn btn-primary btn-sm mt-2">Update password</button>
        </form>
      </div>
    </div>
  </template>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import Network from "../../network-class";
    export default {
        name:'userEdit',
        created(){
           this.getUser();
        },
        mounted(){
        },
      data:() => ({
        id:'',
        errors:[],
        formData: {
                current_password:'',
                password:'',
                password_confirmation:'',
            },
          user:[],
      }),
      methods: {
        getUser: async function () {
            var user=JSON.parse(localStorage.getItem('user'));
            this.user=user;
            this.formData=user;
          },
          update: async function (event) {
            var url='/api/updatePassword';
            const data = await Network.store(url, this.formData);
            if(data.error){this.errors=data.error; this.loading_submit=false;}
            else{
              localStorage.setItem("user", JSON.stringify(data.data));
              this.$router.push('/home');}
          },
        },
    };
    </script>