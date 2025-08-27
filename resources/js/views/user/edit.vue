<template>
    <div>
        <div class="row">
            <div class="col-sm-5">  
    <template>
     <div class="card">
      <div class="card-body">
          <h4 class="not-margin">Update user</h4>
          <form action="#" @submit.prevent="update">

            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" v-model="formData.name">
                <div v-if="errors.name"><span class="text-danger" role="alert">{{errors.name[0]}}</span></div>
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control" v-model="formData.phone">
                <div v-if="errors.phone"><span class="text-danger" role="alert">{{errors.phone[0]}}</span></div>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" name="email" class="form-control" v-model="formData.email">
                <div v-if="errors.email"><span class="text-danger" role="alert">{{errors.email[0]}}</span></div>
            </div>        

            <div class="form-group">
                <label>Role</label>
                <select v-model="formData.role_id"  class="form-select">
                        <option value="1" v-if="computedUser.role.name=='Super admin'">Super Admin</option>
                        <option :value="role.id" :key="role.id" v-for="role in roles">{{role.name}}</option>
                    </select>
                <div v-if="errors.role_id"><span class="text-danger" role="alert">{{errors.role_id[0]}}</span></div>
            </div>
            <div class="form-group" v-if="computedUser.role && computedUser.role.name=='Super admin' && computedUser.company_id==null">
                <label>Company</label>
                <select v-model="formData.company_id"  class="form-select">
                    <option :value="company.id" :key="company.id" v-for="company in companies">{{company.name}}</option>
                </select>
                <div v-if="errors.company_id"><span class="text-danger" role="alert">{{errors.company_id[0]}}</span></div>
            </div>
            
            <button class="btn btn-sm btn-warning mt-2" :disabled="loading_submit"> <span v-if="loading_submit"><i class="fas fa-circle-notch fa-spin"></i></span> {{loading_submit ? 'Loading..' : 'Update'}}</button>
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
           this.id=this.$route.params.id;
           this.getData();
           this.getCompanies();
           this.getRoles();
        },
        mounted(){
        },
      data:() => ({
        loading_submit:false,
        id:'',
        companies:[],
        roles:[],
        errors:[],
        formData: {
            'name':'',
            'phone':'',
            'email':'',
            'password':'',
            'role_id':'',
            },
          user:[],
      }),
      methods: {
        getData: async function () {
            var url='/api/user/'+this.id;
            const data = await Network.get(url);
            this.user=data.data;
            this.formData=data.data;
          },
          update: async function (event) {
            this.loading_submit=true;
            var url='/api/user/'+this.id;
            const data = await Network.update(url, this.formData);
            if(data.error){this.errors=data.error; this.loading_submit=false;}
            else{this.$router.push('/user/'+data.data.id);}
          },
          getCompanies: async function () {
              const data = await Network.get('/api/companies');
              this.companies=data.data;
          },
          getRoles: async function () {
              const data = await Network.get('/api/roles');
              this.roles=data.data;
          },
        },
        computed: {
            computedUser() {
                return this.$store.state.user;
                },
            },
    };
    </script>