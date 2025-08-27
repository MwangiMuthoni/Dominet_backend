<template>
    <div class="pt-4" style="min-height: 100vh;">
      <div class="row justify-content-center pt-4">
        <div class="col-sm-6" style="margin-top: 100px;">
          <div class="">
            <div class="card-body" style="display: flex; flex-direction: column;">
              <h5 style="font-weight: bold; font-size:xx-large; color: #3e5164; text-align:center;">Complete your profile</h5>
  
              <form action="" method="POST" @submit.prevent="register" style="display: flex; flex-direction: column; gap: 10px;">
                <div v-if="error!=null"><span class="text-danger" role="alert">{{error}}</span></div>

                <div class="form-group mt-3" style="display: flex; flex-direction: column;">
                    
                    <input type="file" id="profileImage" style="display: none;" name="profile_picture" @change="handleImageChange" accept="image/png, image/jpeg">
                    <label for="profileImage">
                        <div v-if="!previewImage">
                        <div class="circular-patch" style="width: 100px; height: 100px; border-radius: 50%; background-color: #ddd; border: 2px solid #dddddd; display: block; margin: auto; background-image: url(/img/placeholder-person.png); background-size: cover;">
                            <i class="fas fa-plus" style="font-size: 30px; color: #FF4275; margin:auto; display:block; margin-top: 50%; transform: translateY(-50%);"></i>
                        </div>
                        </div>
                        <div v-if="previewImage" style="padding:5px;">
                            <img :src="previewImage" alt="Profile preview" style="border-radius: 50%; width: 100px;display: block; margin: auto; height: 100px; object-fit: cover; border: 2px solid #dddddd;">
                        </div>
                    </label>
                </div>
  
                <div class="form-group col">
                    <input type="text" name="name" class="form-control" placeholder="Enter your name" v-model="formData.name" required/>
                    <div v-if="errors.name"><span class="text-danger" role="alert">{{errors.name[0]}}</span></div>
                </div>

                <div class="row g-0">
                  <div class="form-group col col-3">
                      <select name="calling_code" v-model="formData.calling_code" class="form-select" style="border-bottom-right-radius: 0px !important; border-top-right-radius: 0px !important; color: #000 !important;" required>
                          <option value="">Select...</option>
                          <option v-for="country in countries" :key="country.id" :value="country.calling_code">{{country.calling_code}}</option>
                      </select>
                    </div>
                    <div class="form-group col col-9">
                      <input
                        type="text"
                        name="phone"
                        class="form-control"
                        v-model="formData.phone"
                        placeholder="Enter your phone number"
                        style="border-bottom-left-radius: 0px !important; border-top-left-radius: 0px !important;"
                        required
                      />
                      <div v-if="errors.phone"><span class="text-danger" role="alert">{{errors.phone[0]}}</span></div>
                    </div>
                </div>

  
                <button class="btn btn-sm btn-warning mt-2 mb-3 w-100" :disabled="loading_submit">
                  <span v-if="loading_submit"><i class="fas fa-circle-notch fa-spin"></i></span>
                  {{loading_submit ? 'Loading..' : 'Complete profile'}}
                </button>
  
              </form>
  
              <error class="" v-if="error_message">{{error_message}}</error>
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
          name:'completeProfile',
          created(){
            this.$store.commit('getUser');
            this.getCountries()
          },
          mounted(){
            this.$store.commit('getUser');
            this.getCountries()
            this.formData.calling_code = '+254'
          },
          data:() => ({
            loading_submit: false,
            loading: false,
            calling_code:'',
            phone: '',
            error_message: false,
            errors: [],
            error: '',
            user: null,
            showPassword: false,
            hideForm: false,
            previewImage: null,
            countries: [],
            formData: {
              name: '',
              phone: '',
              calling_code: ''
            }
        }),
        methods: {

          updatePhone(value) {
              const newValue = value.replace(/\D/g, "");

              const lastNine = newValue.slice(-9);

              if (this.phone !== lastNine) {
                this.phone = lastNine;
              }
            },

            register: async function (event) {
                this.loading_submit = true;

                var user=JSON.parse(localStorage.getItem('user'));

                var url = '/api/update-user-profile';

                const formData = new FormData();
                if (this.previewImage) {
                    formData.append('image', this.formData.image);
                }

                formData.append('name', this.formData.name)
                formData.append('phone', this.formData.phone);
                formData.append('calling_code', this.formData.calling_code);
                formData.append('_method','PUT');

                const data = await Network.storeUpload(url, formData); 
                if (data.error) {
                    this.errors = data.error;
                    this.loading_submit = false;
                } else if (data.error_message) {
                    this.error_message = data.error_message;
                    this.loading_submit = false;
                } else {
                    localStorage.setItem("user", JSON.stringify(data.data));
                    this.$store.commit('getUser');
                    this.$router.push('/confirm-phone')
                }
                
            },

            handleImageChange(event) {
                const file = event.target.files[0];
                this.formData.image  = event.target.files[0];
                const allowedMimeTypes = ["image/jpeg", "image/png", "image/webp", "image/avif"];
                if (!allowedMimeTypes.includes(file.type)) {
                    alert("Only JPG and PNG JPEG AVIF WEBP images are allowed.");
                    return;
                }
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.previewImage = e.target.result;
                };
                reader.readAsDataURL(file);
            },
  
            login: async function (event) {
              this.loading_submit=true;
              var url='/api/login';
              const data = await Network.store(url, this.formData);
              if(data.error){this.error=data.error; this.loading_submit=false;}
              else{
                localStorage.setItem("auth", true);
                localStorage.setItem("user", JSON.stringify(data.user));
                localStorage.setItem("token", data.token.plainTextToken);
                this.$store.commit('getUser');
  
                this.$store.commit('getUser');
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
  
           },
      };
  </script>