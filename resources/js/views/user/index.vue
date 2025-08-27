<template>
    <div>
      <loading-message v-if="loading"></loading-message>
      <div class="row">
        <div class="col-sm-12">
              <div class="row">
                <div class="col-sm-10">
              <h4>Users</h4></div><div class="col-sm-2"><router-link to="/user/create" class="btn btn-sm btn-warning mb-2"><i class="fa fa-plus"></i> Add user</router-link></div></div>
              <div class="table-responsive only-desktop">
          

             <table class="table table-condensed table-bordered">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Phone</th>
                  <th>Email</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="user in users">
                  <td>{{user.name}}</td>
                  <td>{{user.phone}}</td>
                  <td>{{user.email}}</td>
                  <td><router-link :to="'/user/'+user.id" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></router-link></td>
                </tr>
              </tbody>
            </table>

          </div>


          <div class="btn-group custom-pagination">
            <button :class="current_page == link.url?'btn btn-sm active-page':'btn btn-sm'" v-for="(link, index) in links" @click="getData(link.url)" :disabled="link.url==null"><span v-html="link.label"></span></button>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import Network from "../../network-class";
    export default {
        name:'userIndex',
        created(){
           this.getData(window.location.origin+'/api/user?page=1');
        },
        beforeCreate(){
          this.loading=true;
        },
      data:() => ({
        users:[],
        links:[],
        current_page:null,
      }),
      methods: {
          getData: async function (url) {
              const data = await Network.get(url);
              this.users=data.data;
              this.links=data.meta.links;
              this.current_page=url;
              this.loading=false;
          },
        },
    };
    </script>