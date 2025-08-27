<template>
    <div>
      <loading-message v-if="loading"></loading-message>
      <div class="row">
        <div class="col-sm-4">
          <div class="card">
            <div class="card-body">
              <h4>Coupon Details</h4>
              
              <!-- table goes heres -->
              <!-- table goes heres -->
              <!-- table goes heres -->
              <!-- table goes heres -->

              <form action="#" @submit.prevent="deleteData(coupon)" >
              <div class="btn-group mt-2">
                <router-link :to="'/coupon/'+coupon.id+'/edit'" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> Edit</router-link>
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
        name:'couponShow',
        created(){
          this.id=this.$route.params.id;
          this.getData();
        },
        beforeCreate(){
          this.loading=true;
        },
        data:() => ({
        id:'',
        coupon:[],
      }),
      methods: {
          getData: async function () {
            var url='/api/coupon/'+this.id;
            const data = await Network.get(url);
            this.coupon=data.data;
            this.loading=false;
          },
          deleteData: async function (coupon) {
            const isConfirmed = await this.$swal.fire();
            if(isConfirmed.isConfirmed){
              var url='/api/coupon/'+this.id;
              await Network.delete(url);
              this.$router.push('/coupon');
            }

          },
        },
    };
    </script>