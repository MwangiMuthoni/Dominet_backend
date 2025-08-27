<template>
    <div>
      <loading-message v-if="loading"></loading-message>
      <div class="row">
        <div class="col-sm-4">
          <div class="card">
            <div class="card-body">
              <h4>User Details</h4>
              
              <table class="table table-condensed table-bordered">
                <tr><th>Name</th><td>{{user.name}}</td></tr>
                <tr><th>Phone</th><td>{{user.phone}}</td></tr>
                <tr><th>Email</th><td>{{user.email}}</td></tr>
                <tr v-if="user.last_login"><th>Last login</th><td>{{user.last_login}}</td></tr>
                <tr v-if="user.email_verified_at"><th>Email verified at</th><td>{{user.email_verified_at}}</td></tr>
                <tr v-if="user?.role"><th>Role</th><td>{{user?.role}}</td></tr>
                <tr v-if="user?.company"><th>Company</th><td>{{user?.company?.name??''}}</td></tr>
              </table>

              <form action="#" @submit.prevent="deleteData(user)" >
              <div class="btn-group mt-2">
                <router-link :to="'/user/'+user.id+'/edit'" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> Edit</router-link>
                <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</button>
              </div>
            </form>
            </div>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
    import Network from "../../network-class";
    import axios from 'axios'
    export default {
        name:'userShow',
        created(){
          this.id=this.$route.params.id;
          this.getData();
        },
        beforeCreate(){
          this.loading=true;
        },
        data:() => ({
        id:'',
        user:[],
      }),
      methods: {
          getData: async function () {
            var url='/api/user/'+this.id;
            const data = await Network.get(url);
            this.user=data.data;
            this.loading=false;
          },
          deleteData: async function (user) {
            const isConfirmed = await this.$swal.fire();
            if(isConfirmed.isConfirmed){
              var url='/api/user/'+this.id;
              await Network.delete(url);
              this.$router.push('/user');
            }

          },
        },
    };
    </script>