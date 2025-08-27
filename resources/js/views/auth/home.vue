<template>
  <div>
      <page-header title="You are currently using trial version which ends in" v-if="company.is_trial !== null"></page-header>
      <div class="row justify-content-center" style="margin-top:50px;">
        <div class="col-sm-12">
          <div class="row">
              <div class="col-sm-12 mob-space">
                  <h4>Hi {{ user.name }}, welcome.</h4>
              </div>
          </div>

          <div class="row mt-0 g-4">

            <div class="col-sm-10 col-md-6 col-lg-3 flex-parent p-4">
                <doodles
                image="/img/house.png"
                title="Properties"
                number="5"
                linkName="/property"
                />
            </div>

            <div class="col-sm-10 col-md-6 col-lg-3 flex-parent p-4">
                <doodles
                image="/img/calendar.png"
                title="Total visits"
                number="10"
                linkName="/visit"
                />
            </div>

            <div class="col-sm-10 col-md-6 col-lg-3 flex-parent p-4">
                <doodles
                image="/img/monthly_calendar.png"
                title="Monthly visits"
                number="20"
                linkName="/visit"
                />
            </div>

            <div class="col-sm-10 col-md-6 col-lg-3 flex-parent p-4">
                <doodles
                image="/img/clock.png"
                title="Daily visits"
                number="50"
                linkName="/visit"
                />
            </div>
            
          </div>

          <div class="row mt-0 g-4">
            <div class="col-sm-10 col-md-12 col-lg-6 flex-parent">
                <div class="flex-child custom-shadow pad-20 br-20">
                    <div class="card-body">
                      <h4>Recent visitors</h4>
                      <div class='table-responsive'>
                        <table class="table table-condensed table-striped">
                          <thead>
                            <tr>
                              <th>Name</th>
                              <th>Phone</th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="user in users" @click="$router.push('/user/'+user.id)">
                              <td>{{user.name}}</td>
                              <td>{{user.phone}}</td>
                              <td><router-link :to="'/user/'+user.id" ><i class="fa fa-chevron-right"></i></router-link></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                  </div>
                </div>
            </div>

            <!-- <div class="col-sm-10 col-md-12 col-lg-6 flex-parent">
                <div class="flex-child custom-shadow pad-20 br-20">
                    <div class="card-body">
                      <h4>Monthly visits</h4>
                      <div class='table-responsive'>
                          <area-chart :colors="['#FF4275', '#0f4c3d']"  :yAxisLabel="'Visits'"  :xAxisLabel="'Date & time'" :series="monthlyVisitSeries" v-if="formattedVisitTrends.length > 0"></area-chart>
                      </div>
                  </div>
                </div>
            </div> -->
          </div>

        </div>
      </div>
  </div>
</template>

<script>
  import axios from 'axios';
  import Network from "../../network-class";
  import doodles from '../../components/doodles.vue';
  import doods from '../../components/doods.vue';
  import BarGraph from "../../components/charts/bar";
  import datetime from "../../components/datetime.vue"
  import listingThumb from '../../components/listingThumb.vue';
  import AreaChart from "../../components/charts/graph";
  import pageHeader from "../../components/fullwidthPageHeader.vue";

  export default {
      name:'home',
      components: {doodles, doods, BarGraph, datetime, listingThumb, 'area-chart':AreaChart, pageHeader},
      created(){
       this.getDashboardContent()
       this.$store.commit('getUser');
       this.company_id = this.company?.id;
      },
      mounted(){
      },
    data:() => ({
      loading_submit:false,
      errors:[],
      success:false,
      agents: [],
      enquiries: [],
      subscriptions: [],
      activeSubscription: [],
      monthlyEnquiries: [],
      properties: [],
      monthlyEnquiriesSeries: [],
      topTenAgents: [],
      topTenUsers: [],
      topTenEnquiries: [],
      users: [],
      visitors: [],
      breadcrumb_links:[
            {title:'Home',url:'/dash'},
            {title:'Settings',url:'/dashboard/setting'},
        ],
      startDate: '',
      endDate: '',
      company_id: '',
      currentPage: 1,
      itemsPerPage: 8,
      formattedVisitTrends: [],
      monthlyVisitSeries: [],
      currentDayVisits: '',
      currentMonthVisits: '',
      totalVisits: '',
    }),
    methods: {

          setDate(value) {
            this.startDate=value.startDate;
            this.endDate=value.endDate;
            this.getDashboardContent()
          },

          getDashboardContent: async function () {
              const data = await Network.get(`/api/dashboard-content?startDate=${this.startDate}&endDate=${this.endDate}&company_id=${this.company_id}`);

              this.users = data.visitors;
          },
          prevPage() {
              if (this.currentPage > 1) {
                  this.currentPage--;
              }
          },
          nextPage() {
              if (this.currentPage < this.totalPages) {
                  this.currentPage++;
              }
          }
       },
      computed: {
          user() {
          return this.$store.state.user;
          },
          company() {
          return this.$store.state.company;
          },
          paginatedProperties() {
              const start = (this.currentPage - 1) * this.itemsPerPage;
              const end = start + this.itemsPerPage;
              return this.properties.slice(start, end);
          },
          totalPages() {
              return Math.ceil(this.properties.length / this.itemsPerPage);
          }
      },
  };
  </script>