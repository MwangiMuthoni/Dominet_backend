<template>
  <div class="pt-4" style="min-height: 100vh;">
    <div class="row d-flex justify-content-center h-100 pt-4">
      <div class="col-sm-12" style="margin-top: 100px;">
        <span style="display:block; margin: auto; font-size: 30px; text-align: center; margin-bottom: 20px; color:#FF4275;"><img src='/img/house.png' alt='' style="width: 100px;" /></span>
        <h5 style="font-weight: bold; font-size:xx-large; color: #3e5164; text-align: center; margin-bottom: 10px;">Get started with spa</h5>
        <p style="text-align: center;">Hello <strong>{{person?.name}}</strong>. Are you a Company or an Individual?</p>

        <div class="row g-2 d-flex justify-content-center">
            <div class="col-sm-4">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column">
                      <h4>Individual</h4>
                      <p>As an individual, you'll gain access to personal benefits and features tailored for individual use.</p>
                      <button class="btn btn-sm whiteTitlecompany" style="background-color: #29a8d2; margin-top: auto;" type="button" @click.prevent="goToSubscriptionPackage">
                          Individual
                      </button>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column">
                      <h4>Company</h4>
                      <p>For companies, we offer packages designed to fit organizational needs with additional features and support.</p>
                      <button class="btn btn-sm whiteTitlecompany" style="background-color: #29a8d2; margin-top: 20px;" type="button" @click.prevent="goToCreateCompany">
                          Company
                      </button>
                    </div>
                </div>
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
          name:'getStarted',
          created(){
            this.type = 'Individual'
          },
          mounted(){
            this.company = JSON.parse(window.localStorage.getItem('company'));
            this.person = JSON.parse(window.localStorage.getItem('user'));
          },
          data:() => ({
            company:'',
            person: '',
            type: ''
        }),
        methods: {

            goToSubscriptionPackage () {
                this.$router.push('/subscription-package');
            },

            goToCreateCompany () {
                this.$router.push('/create-company');
            },
        },
      };
  </script>