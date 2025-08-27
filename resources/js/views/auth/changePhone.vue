<template>
    <div class="row justify-content-center pt-4" style="min-height: 100vh;">
      <div class="col-sm-6 text-center" style="margin-top: 100px;">
        <form action="" method="POST" @submit.prevent="register">
            <div v-if="error!=null"><span class="text-danger" role="alert">{{error}}</span></div>
                <div class="row g-0">
                    <div class="form-group col col-3">
                      <!-- <label>Phone</label> -->
                      <select name="calling_code" v-model="formData.calling_code" class="form-select" style="border-bottom-right-radius: 0px !important; border-top-right-radius: 0px !important;" required>
                          <option value="">Select...</option>
                          <option v-for="country in countries" :key="country.id" :value="country.calling_code">{{country.calling_code}}</option>
                      </select>
                    </div>
                    <div class="form-group col col-9">
                      <!-- <label></label> -->
                      <input
                        type="text"
                        name="phone"
                        class="form-control"
                        v-model="phone"
                        placeholder="Enter your phone number"
                        @input="updatePhone($event.target.value)"
                        style="border-bottom-left-radius: 0px !important; border-top-left-radius: 0px !important;"
                        required
                      />
                      <div v-if="errors.phone"><span class="text-danger" role="alert">{{errors.phone[0]}}</span></div>
                    </div>
                </div>

                <button class="btn btn-sm btn-warning mt-2 mb-3 w-100" :disabled="loading_submit">
                <span v-if="loading_submit"><i class="fas fa-circle-notch fa-spin"></i></span>
                {{loading_submit ? 'Loading..' : 'Change phone'}}
                </button>

            <h5><router-link to="/confirm-phone">Go back?</router-link></h5>

        </form>
      </div>
    </div>
</template>
  
<script>
    import axios from 'axios';
    import Network from "../../network-class";

    export default {
        name:'changePhone',
        created(){
          this.getUser();

          this.getCountries()
          this.formData.calling_code = '+254'
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
        countries: [],
        phone: '',
        formData:{
          calling_code:'',
          phone:'',
        }
      }),
      methods: {
        register: async function (event) {
            this.loading_submit=true;
            var url='/api/change-phone';
            
            const data = await Network.update(url, this.formData);
            if(data.error){this.errors=data.error; this.loading_submit=false;}
            else if(data.error_message){this.error_message=data.error_message; this.loading_submit=false;}
            else{
                this.loading_submit=true;
                localStorage.setItem("user", JSON.stringify(data.data));
                this.$router.push('/confirm-phone')
            }
          },


          getUser(){
            var user=JSON.parse(localStorage.getItem('user'));
            this.user=user;
          },

          toggleShow() {
            this.showPassword = !this.showPassword;
          },

          getCountries: async function () {
                const data = await Network.get('/api/countries');
                this.countries=data.countries;
            },

          updatePhone(value) {
                const newValue = value.replace(/\D/g, "");

                const lastNine = newValue.slice(-9);

                if (this.phone !== lastNine) {
                this.phone = lastNine;

                this.formData.phone = lastNine;
                }
            },


         },
    };
</script>