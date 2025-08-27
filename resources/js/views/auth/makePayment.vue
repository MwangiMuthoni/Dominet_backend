<template>
  <div class="pt-4" style="min-height: 100vh;">
    <div class="row justify-content-center" style="margin-top: 100px;">
      <div class="col-lg-8 mt-4" v-if="iframe_url == null">
        <div class="row g-2 pt-2 justify-content-center">
          <div class="col-sm-6">
            <div class="card h-100">
              <div class="card-body d-flex flex-column">
                <h4>{{ selectedPackage.title }}</h4>
                <p>{{ selectedPackage.description }}</p>
                <h4><span>KES {{ calculatedAmount }}</span></h4>
                <img src="/img/mpesa.png" alt="" style="width: 150px" />
                <form action="#" @submit.prevent="save" style="display: flex; flex-direction: column; gap: 10px;">

                  <div class="form-group" v-if="selectedPackage.title != 'One time'">
                    <label>Cycle</label>
                    <select class="form-select" v-model="formData.cycle">
                      <option value="Monthly">Monthly</option>
                      <option value="Yearly">Yearly</option>
                    </select>
                  </div>

                  <div class="row g-0">
                    <div class="form-group col col-3">
                      <select name="calling_code" v-model="formData.calling_code" class="form-select" style="border-bottom-right-radius: 0px !important; border-top-right-radius: 0px !important;" required>
                        <option value="">Select...</option>
                        <option v-for="country in countries" :key="country.id" :value="country.calling_code">{{ country.calling_code }}</option>
                      </select>
                    </div>
                    <div class="form-group col col-9">
                      <input type="text" name="phone" class="form-control" v-model="formData.phone" placeholder="Enter your phone number" style="border-bottom-left-radius: 0px !important; border-top-left-radius: 0px !important;" required />
                      <div v-if="errors.phone"><span class="text-danger" role="alert">{{ errors.phone[0] }}</span></div>
                    </div>
                  </div>

                  <button class="btn btn-sm btn-warning w-100 mt-2" :disabled="loading_submit">
                    <span v-if="loading_submit"><i class="fas fa-circle-notch fa-spin"></i></span>
                    {{ loading_submit ? 'Loading..' : 'Continue to make payment' }}
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-8 mt-4" v-if="iframe_url != null">
        <iframe :src="iframe_url" v-if="iframe_url != null" width="100%" height="500px"></iframe>
      </div>
    </div>

    <error v-if="error_message">{{ error_message }}</error>
  </div>
</template>

  

<script>
import axios from 'axios';
import Network from "../../network-class";
import moment from 'moment';

export default {
  name: 'makePayment',
  created() {
    this.$store.commit('getUser');
    this.$store.commit('getCompany');
    this.getCountries();
    this.getPackage();
    this.formData.calling_code = '+254';
    this.formData.phone = this.user.phone;
    this.formData.cycle = 'Monthly';
    this.formData.number = 1;

    if (this.user?.latest_bill?.period === 'Yearly') {
      this.showPeriod = true;
    } else {
      this.showPeriod = false;
    }

    this.formData.package_id = this.$route.params.id;

    if(this.company?.properties?.length > 0) {
      this.formData.number = this.company?.properties?.length
    }
  },
  data() {
    return {
      loading_submit: false,
      error_message: false,
      errors: [],
      countries: [],
      interval: null,
      showPeriod: true,
      iframe_url: null,
      edit_id: '',
      package: [],
      packages: [],
      formData: {
        calling_code: '',
        cycle: '',
        phone: '',
        number: 1,
        schedule: 'Monthly',
      },
      selectedPackage: {},
    };
  },
  methods: {
    save: async function (event) {
      this.loading_submit = true;
      var url = '/api/pesapal/payment/initiate';

      const data = await Network.store(url, {
        'user_id': this.user.id,
        'cycle': this.formData.cycle,
        'amount': this.calculatedAmount
      });

      if (data.error) {
        this.errors = data.error;
        this.loading_submit = false;
      } else if (data.error_message) {
        this.error_message = data.error_message;
        this.loading_submit = false;
      } else if (data.success) {
        this.iframe_url = data.url;
        this.interval = setInterval(() => { this.getCompany(); }, 5 * 1000);
        this.loading_submit = false;
      }
    },
    getCountries: async function () {
      const data = await Network.get('/api/countries');
      this.countries = data.countries;
    },
    async getPackage() {
      const data = await Network.get('/api/packages/');
      this.packages = data.packages.map(pkg => ({ ...pkg, loading: false }));
      this.updateSelectedPackage();
    },
    updateSelectedPackage() {
      const selectedPkg = this.packages.find(pkg => pkg.id === this.formData.package_id);
      if (selectedPkg) {
        this.selectedPackage = selectedPkg;
      }
    },
    getCompany: async function () {
      const data = await Network.get('/api/company/' + this.user.company_id);
      var companyDetails = data.data;
      if (companyDetails.latest_bill != null && companyDetails.latest_bill.status == 'Paid') {
        clearInterval(this.interval);
        this.$router.push('/home');
      }
    },
  },
  computed: {
    user() {
      return this.$store.state.user;
    },
    company() {
      return this.$store.state.company;
    },
    calculatedAmount() {
      const basePrice = this.formData.cycle === 'Monthly' ? 1000 : 1000 * 12;
      return basePrice * this.formData.number;
    }
  },
  watch: {
    'formData.package_id': 'updateSelectedPackage',
  },
};
</script>


