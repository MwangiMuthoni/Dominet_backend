<template>
  <div style="min-height: 100vh;">
      <div class="row justify-content-center mt-5">
          <div class="col-sm-6 mt-5"></div>
      </div>
      <div class="row justify-content-center" style="margin-top:50px;">
          <div class="col-sm-4 mt-5">
              <h5 style="font-weight: bold; font-size:32px; color: #0f4c3d; text-align:center;">Sign in to your spa account.</h5>
              <!-- <div style="display: flex; align-items: center;" class="loginWithBrand" @click="AuthProvider('google')">
                  <img src="/img/logo/search.png" width="20px" alt="Google icon" style="margin: auto 0;" />
                  <p style="margin: auto 0;">Continue with Google</p>
              </div>

              <div style="display: flex; align-items: center;" class="loginWithBrand" @click="AuthProvider('facebook')">
                  <img src="/img/logo/facebook.png" width="20px" alt="Google icon" style="margin: auto 0;" />
                  <p style="margin: auto 0;">Sign in with Facebook</p>
              </div>
              <div class="text-center" style="display: flex; align-items: center; justify-content: center; margin-top: 10px;">
                  <span class="orLine flex-grow"></span>
                  <span>or</span>
                  <span class="orLine flex-grow"></span>
              </div> -->

              <form action="" method="POST" @submit.prevent="login">
                  <div v-if="error!=null"><span class="text-danger" role="alert">{{error}}</span></div>
                  <div class="form-group mt-3">
                      <label>Email</label>
                      <input type="email" name="email" v-model="formData.email" placeholder="name@your-email.com" class="form-control">
                  </div>

                  <div class="form-group">
                      <label>Password</label>
                      <div class="input-group mb-3">
                          <input v-if="showPassword" type="text" class="form-control" v-model="formData.password" />
                          <input v-else type="password" class="form-control" v-model="formData.password">
                          <button class="btn btn-info" @click.prevent="toggleShow">
                              <i class="fa fa-eye" v-if="!showPassword"></i>
                              <i class="fa fa-eye-slash" v-else></i>
                          </button>
                      </div>
                  </div>
                  <button class="btn btn-sm btn-warning mt-2 mb-3 w-100" style="background-color: #4C0F1E; color: white; border: none;" :disabled="loading_submit">
                      <span v-if="loading_submit"><i class="fas fa-circle-notch fa-spin"></i></span>
                      {{loading_submit ? 'Loading..' : 'Sign In With Email'}}
                  </button>

                  <div class="" style="width: 100%; display: flex; align-items: center; justify-content: space-between;">
                      <router-link to="/register">
                          <span style="color: #3c6ecc">Register now</span>
                      </router-link>
                      <router-link to="/forgot"> Forgot your password?</router-link>
                  </div>
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
  name: 'login',
  components: {},
  created() {
  },
  mounted() {},
  data: () => ({
      loading_submit: false,
      loading: false,
      error_message: false,
      errors: [],
      error: '',
      user: [],
      userDepartments: [],
      showPassword: false,
      formData: {
          email: '',
          password: '',
      }
  }),
  methods: {
      login: async function (event) {
          this.loading_submit = true;
          var url = '/api/login';
          const data = await Network.store(url, this.formData);
          if (data.error) {
              this.error = data.error;
              this.loading_submit = false;
          } else {
              localStorage.setItem("auth", true);
              localStorage.setItem("user", JSON.stringify(data.user));
              if(data?.user?.company) {
                localStorage.setItem("company", JSON.stringify(data?.company));
              }
              localStorage.setItem("token", data.token.plainTextToken);
              this.$store.commit('getUser');

              this.user = data.user;

              if(data.user) {

                if(parseInt(data.user.role_id) === 1){
                    this.$router.push('/home');
                }
                else {
                    this.getUserRegistrationJourney(data.user.id);
                }
              }

          }
      },

      getUserRegistrationJourney: async function (id) {
        var url = '/api/get-registration-journey/' + id;
        const response = await axios.get(url);
        const journey = response.data;

        if (parseInt(journey.register) != 1) {
            this.$router.push('/register');
            this.$store.commit('getUser');
        } else if (parseInt(journey.confirm_email) != 1) {
            this.$router.push('/confirm-email');
            this.$store.commit('getUser');
        } else if (parseInt(journey.complete_profile) != 1) {
            this.$router.push('/complete-profile');
            this.$store.commit('getUser');
        }
        else if (parseInt(journey.confirm_phone) != 1) {
            this.$router.push('/confirm-phone');
            this.$store.commit('getUser');
        }
        else if (parseInt(journey.complete) != 1 && this.user.company_id === null) {
            this.$router.push('/create-company');
            this.$store.commit('getUser');
        }
        else {
            this.$router.push('/home');
            this.$store.commit('getUser');
        }
      },

      toggleShow() {
          this.showPassword = !this.showPassword;
      },

      AuthProvider(provider) {
          var self = this;
          this.$auth.authenticate(provider).then(response => {
              self.SocialLogin(provider, response);
          }).catch(err => {
              console.log({ err: err });
          });
      },

      SocialLogin(provider, response) {
          this.$http.post('/api/sociallogin/' + provider, response).then(response => {
              const data = response.data;
              localStorage.setItem("auth", true);
              localStorage.setItem("user", JSON.stringify(data.user));
              localStorage.setItem("token", data.token.plainTextToken);
              this.$store.commit('getUser');
          }).catch(err => {
              console.log({ err: err });
          });
      },

  },
};
</script>
