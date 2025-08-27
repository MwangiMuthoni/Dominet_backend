<template>
    <div class="pt-4">
      <div class="row pt-4 d-flex justify-content-center">
        

        <div class="col-sm-6" style="margin-top: 100px;">
            <h5 style="font-weight: bold; font-size:xx-large; color: #3e5164;">Register a company</h5>
          <div class="">
            <div class="card-body">
  
              <form action="" method="POST" @submit.prevent="register">
                    <div v-if="error!=null"><span class="text-danger" role="alert">{{error}}</span></div>

                    <div class="">
                        <div class="form-group mt-3" style="display: flex; flex-direction: column;">
                            <input type="file" id="profileImage" style="display: none;" name="profile_picture" @change="handleImageChange" accept="image/png, image/jpeg">
                            <label for="profileImage">
                                <div v-if="!previewImage" style="display: flex; align-items: center;">
                                <div class="circular-patch" style="width: 100px; height: 100px; border-radius: 5px; background-color: #ddd; text-align: center; border: 1px solid #dddddd;">
                                    <i class="fas fa-plus" style="font-size: 30px; color: #888; margin-top: 50%; transform: translateY(-50%);"></i>
                                </div>
                                </div>
                                <div v-if="previewImage" style="display: flex;">
                                    <img :src="previewImage" alt="Profile preview" style="border-radius: 5px; width: 100px; object-fit: cover; border: 1px solid #dddddd;">
                                </div>
                            </label>
                            <label for="profileImage">Select a logo for your company</label>
                        </div>
        
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" v-model="formData.name" required/>
                            <div v-if="errors.name"><span class="text-danger" role="alert">{{errors.name[0]}}</span></div>
                        </div>

                        <div class="form-group">
                            <label>Phone</label>
                        </div>

                        <div class="row g-0">
                            <div class="form-group col col-3">
                            <select name="calling_code" v-model="formData.calling_code" class="form-select" style="border-bottom-right-radius: 0px !important; border-top-right-radius: 0px !important;" required>
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

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" v-model="formData.email" required/>
                            <div v-if="errors.email"><span class="text-danger" role="alert">{{errors.email[0]}}</span></div>
                        </div>

                    </div>

                    <div class="">
                        <div class="form-group">
                            <label>Contact person</label>
                            <input type="text" name="contact_person" class="form-control" v-model="formData.contact_person" required/>
                            <div v-if="errors.contact_person"><span class="text-danger" role="alert">{{errors.contact_person[0]}}</span></div>
                        </div>

                        <div class="form-group">
                            <label>Contact phone</label>
                        </div>

                        <div class="row g-0">
                            <div class="form-group col col-3">
                            <select name="director_calling_code" v-model="formData.director_calling_code" class="form-select" style="border-bottom-right-radius: 0px !important; border-top-right-radius: 0px !important;" required>
                                <option value="">Select...</option>
                                <option v-for="country in countries" :key="country.id" :value="country.calling_code">{{country.calling_code}}</option>
                            </select>
                            </div>
                            <div class="form-group col col-9">
                            <input
                                type="text"
                                name="phone"
                                class="form-control"
                                v-model="formData.contact_phone"
                                placeholder="Enter your phone number"
                                style="border-bottom-left-radius: 0px !important; border-top-left-radius: 0px !important;"
                                required
                            />
                            <div v-if="errors.contact_phone"><span class="text-danger" role="alert">{{errors.contact_phone[0]}}</span></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Contact email</label>
                        <input type="email" name="contact_email" class="form-control" v-model="formData.contact_email" required/>
                        <div v-if="errors.contact_email"><span class="text-danger" role="alert">{{errors.contact_email[0]}}</span></div>
                    </div>

                    <div class="row mt-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" v-model="termsChecked" true-value="1" false-value="0" id="termsCheckbox" required>
                            <label>I have read and understood the <router-link to="/pages/2/terms-and-condition">Terms and Conditions of spa.</router-link></label>
                        </div>
                    </div>

                    <div class="">
                        
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <button class="btn btn-sm btn-warning mt-2 col-3" :disabled="loading_submit || termsChecked === '0'"> <span v-if="loading_submit"><i class="fas fa-circle-notch fa-spin"></i></span> {{loading_submit ? 'Creating...' : 'Save'}}</button>
                        </div>
                    </div>
  
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
      import moment from 'moment';

      export default {
          name:'createCompany',
          created(){
            this.getCountries();
            this.formData.calling_code = '+254'
              this.formData.director_calling_code = '+254'
          },
          mounted(){
            const storedUser = JSON.parse(window.localStorage.getItem('user'));
            this.user = storedUser;
          },
          data:() => ({
            loading_submit: false,
            loading: false,
            error_message: false,
            errors: [],
            countries: [],
            country: '',
            query: '',
            items: [],
            phone: '',
            error: '',
            user: null,
            currentStep: 1,
            showPassword: false,
            hideForm: true,
            selectedLocation: null,
            locationOptions: [],
            previewImage: null,
            termsChecked: '0',
            formData: {
                name: '',
                phone: '',
                email: '',
                contact_person:'',
                contact_phone: '',
                calling_code: '',
                director_calling_code: '',
                accepted_terms: '',
                is_trial: 1,
                trial_start_date: moment(new Date()).format('YYYY-MM-DD'),
                trial_end_date: moment(new Date()).add(30, 'days').format('YYYY-MM-DD'),
            }
        }),
        methods: {
            save: async function (event) {
                this.trackState = 1
                this.currentStep = 1
            },
            save1: async function (event) {
                this.trackState = 2
                this.currentStep = 2
            },
            save2: async function (event) {
                this.trackState = 3
                this.currentStep = 3
            },
            register: async function (event) {
                this.loading_submit = true;
                var url = '/api/company';

                const formData = new FormData();
                if (this.previewImage) {
                    formData.append('logo', this.formData.image);
                }

                formData.append('name', this.formData.name)
                formData.append('phone', this.formData.calling_code+this.formData.phone)
                formData.append('email', this.formData.email)
                formData.append('contact_person', this.formData.contact_person)
                formData.append('contact_phone', this.formData.director_calling_code+this.formData.contact_phone)
                formData.append('contact_email', this.formData.contact_email)
                formData.append('is_trial', this.formData.is_trial)
                formData.append('trial_start_date', this.formData.trial_start_date)
                formData.append('trial_end_date', this.formData.trial_end_date)

                const data = await Network.store(url, formData); 

                if (data.error) {
                    this.errors = data.error;
                    this.loading_submit = false;
                } else if (data.error_message) {
                    this.error_message = data.error_message;
                    this.loading_submit = false;
                } else {
                  localStorage.setItem("user", JSON.stringify(data?.user));
                  localStorage.setItem("company", JSON.stringify(data?.company));
                  this.$router.push('/home');
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


            getCountries: async function () {
                var url='/api/countries';
                const data = await Network.get(url);
                this.countries=data.countries;
            },

            checkTerms() {
                this.termsChecked = !this.termsChecked;
            },
  
           },

      };


  </script>