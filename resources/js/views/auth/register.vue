<template>
    <div style="min-height: 100vh;">
      <div class="row justify-content-center mt-5">
        <div class="col-sm-6 mt-5">
          
        </div>
      </div>
        <div class="row justify-content-center" style="margin-top:50px;">
          <div class="col-sm-4 mt-5">
              <h5 style="font-weight: bold; font-size:32px; color: #0f4c3d; text-align:center;">Sign up to your spa account.</h5>
  
  
              <form action="" method="POST" @submit.prevent="register">
                <div v-if="error!=null"><span class="text-danger" role="alert">{{error}}</span></div>
                <div class="form-group mt-3" style="display: flex; flex-direction: column; align-items: flex-start;">
                  <label style="padding: 10px 5px;">Email</label>
                  <input type="email" name="email" v-model="formData.email" placeholder="name@your-email.com"class="form-control" required>
                  <div v-if="errors.email"><span class="text-danger" role="alert">{{errors.email[0]}}</span></div>
                </div>
  
                <div class="form-group" style="display: flex; flex-direction: column; align-items: flex-start;">
                  <label style="padding: 10px 5px;">Password</label>
                  <div class="input-group mb-3">
                    <input v-if="showPassword" type="text" class="form-control" v-model="formData.password" required />
                    <input v-else type="password" class="form-control" v-model="formData.password">
                    <button class="btn btn-info" @click.prevent="toggleShow">
                      <i class="fa fa-eye" v-if="!showPassword"></i>
                      <i class="fa fa-eye-slash" v-else></i>
                    </button>
  
                  </div>
  
                  <div v-if="formData.password">
                    <span>Password Strength: </span>
                    <span v-bind:class="{ weak: score <= 2, medium: score <= 4, strong: score > 4 }">{{ getStrengthText(score) }}</span>
                  </div>
  
                  <div v-if="errors.password"><span class="text-danger" role="alert">{{errors.password[0]}}</span></div>
                </div>
  
                <div class="row">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" v-model="termsChecked" true-value="1" false-value="0" id="termsCheckbox" required>
                    <label>I have read and understood the <router-link to="/pages/2/terms-and-condition">Terms and Conditions of spa LTD.</router-link>
                    </label>
                    <div v-if="errors.terms"><span class="text-danger" role="alert">{{errors.terms[0]}}</span></div>
                  </div>
                </div>
  
                <button class="btn btn-sm btn-warning mt-2 mb-3 w-100" style="background-color: #4C0F1E; color: white; border: none;" :disabled="termsChecked === '0' || loading_submit">
                  <span v-if="loading_submit"><i class="fas fa-circle-notch fa-spin"></i></span>
                  {{ loading_submit ? 'Loading..' : 'Sign up With Email' }}
                </button>
  
                <h5><router-link to="/login">Already have an account?</router-link></h5>
  
              </form>
  
          </div>
        </div>
  
        <error class="" v-if="error_message">{{error_message}}</error>
    </div>
  </template>
  
  <script>
      import axios from 'axios';
      import Network from "../../network-class";
  
      export default {
          name:'userRegister',
          created(){
            this.getUser();
            if(this.user!=null){
              this.$router.push('/home');
            }
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
          termsChecked: '0',
          formData:{
            email:'',
            password:'',
            accepted_terms: ''
          }
        }),
        methods: {
          register: async function (event) {
              this.loading_submit=true;
              var url='/api/register-user';
              this.formData.accepted_terms = this.termsChecked;
  
              const data = await Network.store(url, this.formData);
        
              if(data.error){
                this.errors=data.error;
                this.loading_submit=false;
              }
              else if(data.error_message){
                this.error_message=data.error_message;
                 this.loading_submit=false;
                }
              else{
                this.login()
              }
            },
  
            login: async function (event) {
              this.loading_submit=true;
              var url='/api/login';
              const data = await Network.store(url, this.formData);
              if(data.error){this.error=data.error; this.loading_submit=false;}
              else{
                this.loading_submit=false;
                localStorage.setItem("auth", true);
                localStorage.setItem("token", data.token.plainTextToken);
                localStorage.setItem("user", JSON.stringify(data.user));
                this.$router.push('/confirm-email');
              }
            },
  
            getUser(){
              var user=JSON.parse(localStorage.getItem('user'));
              this.user=user;
            },
  
            toggleShow() {
              this.showPassword = !this.showPassword;
            },
  
            AuthProvider(provider) {
                var self = this
                this.$auth.authenticate(provider).then(response =>{
                  self.SocialLogin(provider,response)
                  }).catch(err => {console.log({err:err})})
              },
            SocialLogin(provider,response){
                this.$http.post('/api/sociallogin/'+provider,response).then(response => {
                    console.log(response.data)
                    const data=response.data;
                    localStorage.setItem("auth", true);
                    localStorage.setItem("user", JSON.stringify(data.user));
                    localStorage.setItem("token", data.token.plainTextToken);
                    this.$store.commit('getUser');
                    this.$router.go();
                }).catch(err => {console.log({err:err})})
            },
  
            getStrengthText(score) {
              switch (score) {
                case 0:
                case 1:
                  return "Very Weak";
                case 2:
                case 3:
                  return "Weak";
                case 4:
                  return "Medium";
                default:
                  return "Strong";
              }
            },
  
            calculatePasswordStrength(password) {
              let score = 0;
              const hasUppercase = /[A-Z]/.test(password);
              const hasLowercase = /[a-z]/.test(password);
              const hasNumbers = /[0-9]/.test(password);
              const hasSymbols = /[!@#$%^&*()_+\-=\[\]{};':\\|,.<>\/?`~]/.test(password);
              const length = password.length;
  
              if (length >= 8) score += 1;
              if (length >= 12) score += 1;
              if (hasUppercase) score += 1;
              if (hasLowercase) score += 1;
              if (hasNumbers) score += 1;
              if (hasSymbols) score += 1;
  
              return score;
            },
  
            checkTerms() {
              this.termsChecked = !this.termsChecked;
            },
  
           },
  
           watch: {
            'formData.password': function (newVal) {
              if (newVal) {
                this.score = this.calculatePasswordStrength(newVal);
              }
            }
          }
      };
  </script>