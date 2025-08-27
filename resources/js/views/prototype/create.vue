<template>
    <div>
        <div class="row">
            <div class="col-sm-5">  
    <template>
     <div class="card">
      <div class="card-body">
          <h4 class="not-margin">Add new Coupon</h4>
          <form action="#" @submit.prevent="save">
            
            <button class="btn btn-sm btn-warning mt-2" :disabled="loading_submit"> <span v-if="loading_submit"><i class="fas fa-circle-notch fa-spin"></i></span> {{loading_submit ? 'Loading..' : 'Save'}}</button>
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
        name:'couponIndex',
        created(){
           
        },
        mounted(){
        },
      data:() => ({
        loading_submit:false,
        errors:[],
        formData: {
                
            },
      }),
      methods: {
          save: async function (event) {
            this.loading_submit=true;
            var url='/api/coupon';
            const data = await Network.store(url, this.formData);
            if(data.error){this.errors=data.error; this.loading_submit=false;}
            else{this.$router.push('/coupon/'+data.data.id);}
          },
        },
    };
    </script>