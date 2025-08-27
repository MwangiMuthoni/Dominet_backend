<template>
    <div>
        <div class="row">
            <div class="col-sm-5">  
    <template>
     <div class="card">
      <div class="card-body">
          <h4 class="not-margin">Update coupon</h4>
          <form action="#" @submit.prevent="update">
            
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
        name:'couponEdit',
        created(){
           this.id=this.$route.params.id;
           this.getData();
        },
        mounted(){
        },
      data:() => ({
        loading_submit:false,
        id:'',
        errors:[],
        formData: {
              
            },
          coupon:[],
      }),
      methods: {
        getData: async function () {
            var url='/api/coupon/'+this.id;
            const data = await Network.get(url);
            this.coupon=data.data;
            this.formData=data.data;
          },
          update: async function (event) {
            this.loading_submit=true;
            var url='/api/coupon/'+this.id;
            const data = await Network.update(url, this.formData);
            if(data.error){this.errors=data.error; this.loading_submit=false;}
            else{this.$router.push('/coupon/'+data.data.id);}
          },
        },
    };
    </script>