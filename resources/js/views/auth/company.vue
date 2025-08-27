<template>
    <div>
        <div class="row justify-content-center" style="margin-top:50px;">
          <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-12">
                    <div class="row g-1 mt-0 d-flex justify-content-end">
                        <div class="col-sm-5 form-group mt-2">
                            <datetime @daterange="setDate"></datetime>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-0 g-4">
              <div class="col-sm-10 col-md-6 col-lg-3 flex-parent p-4">
                  <doodles
                  image="/img/subscription.png"
                  title="Listings"
                  :number="listings?.length"
                  linkName="/subscription"
                  />
              </div>

              <div class="col-sm-10 col-md-6 col-lg-3 flex-parent p-4">
                  <doodles
                  image="/img/help.png"
                  title="Enquiries"
                  :number="enquiries?.length"
                  linkName="/enquiry"
                  />
              </div>

              <div class="col-sm-10 col-md-6 col-lg-3 flex-parent p-4">
                  <doodles
                  image="/img/agents.png"
                  title="Agents"
                  :number="agents?.length"
                  linkName="/user"
                  />
              </div>

              <div class="col-sm-10 col-md-6 col-lg-3 flex-parent p-4">
                  <doods
                  image="/img/activeSubscription.png"
                  title="Active Subscription"
                  :number="activeSubscription?.package?.title"
                  linkName="/subscription"
                  :expiryDate="activeSubscription?.expiry_date"
                  />
              </div>

            </div>

            <div class="row mt-0 g-4">
              <div class="col-sm-10 col-md-12 col-lg-6 flex-parent">
                  <div class="flex-child custom-shadow pad-20 br-20">
                      <div class="card-body">
                        <h4>Monthly enquiries</h4>

                        <div class='table-responsive'>
                            <BarGraph :colors="['#FF4275', '#0f4c3d']"  :yAxisLabel="'Seconds'"  :xAxisLabel="'Date & time'" :series="monthlyEnquiriesSeries" v-if="monthlyEnquiries.length > 0"></BarGraph>
                        </div>

                    </div>
                  </div>
              </div>

              <div class="col-sm-10 col-md-12 col-lg-6 flex-parent">
                  <div class="flex-child custom-shadow pad-20 br-20">
                      <div class="card-body">
                        <h4>Monthly visits</h4>

                        <div class='table-responsive'>
                            <BarGraph :colors="['#FF4275', '#0f4c3d']"  :yAxisLabel="'Seconds'"  :xAxisLabel="'Date & time'" :series="monthlyVisitSeries" v-if="formattedVisitTrends.length > 0"></BarGraph>
                        </div>

                    </div>
                  </div>
              </div>
            </div>

            <div class="row mt-0 g-4">
              <div class="col-sm-12 col-md-12 col-lg-12 mt-4 px-4">
                <h4 class="px-2">Listings</h4>
                <div class="row">
                  <listing-thumb v-for="listing in paginatedListings" :key="listing.id" :listing="listing"></listing-thumb>
                </div>

                <div class="custom-pagination">
                  <button 
                    @click="prevPage"
                    :disabled="currentPage === 1"
                    class="btn btn-sm"
                  >
                    Previous
                  </button>
                  <span>Page {{ currentPage }} of {{ totalPages }}</span>
                  <button 
                    @click="nextPage"
                    class="btn btn-sm"
                    :disabled="currentPage === totalPages"
                  >
                    Next
                  </button>
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
    import doodles from '../../components/doodles.vue';
    import doods from '../../components/doods.vue';
    import BarGraph from "../../components/charts/bar";
    import datetime from "../../components/datetime.vue"
    import ListingThumb from '../../components/listingThumb.vue';

    export default {
        name:'home',
        components: {doodles, doods, BarGraph, datetime, ListingThumb},
        created(){
            this.getDashboardContent()
            this.$store.commit('getUser');
            this.$store.commit('getCompany');
            this.company_id = this.company.id;
        },
        data: () => ({
            loading_submit: false,
            errors: [],
            success: false,
            agents: [],
            enquiries: [],
            subscriptions: [],
            activeSubscription: [],
            monthlyEnquiries: [],
            monthlyEnquiriesSeries: [],
            topTenAgents: [],
            topTenUsers: [],
            topTenEnquiries: [],
            listings: [],
            startDate: '',
            endDate: '',
            company_id: '',
            currentPage: 1,
            itemsPerPage: 8,
            formattedVisitTrends: [],
            monthlyVisitSeries: [],
        }),
        computed: {
            user() {
                return this.$store.state.user;
            },
            company() {
                return this.$store.state.company;
            },
            paginatedListings() {
                const start = (this.currentPage - 1) * this.itemsPerPage;
                const end = start + this.itemsPerPage;
                return this.listings.slice(start, end);
            },
            totalPages() {
                return Math.ceil(this.listings.length / this.itemsPerPage);
            }
        },
        methods: {
            setDate(value) {
                this.startDate = value.startDate;
                this.endDate = value.endDate;
                this.getDashboardContent()
            },
            getDashboardContent: async function () {
                const data = await Network.get(`/api/dashboard-content?startDate=${this.startDate}&endDate=${this.endDate}&company_id=${this.company_id}`);

                this.agents = data.agents;
                this.enquiries = data.enquiries;
                this.subscriptions = data.subscriptions;
                this.activeSubscription = data.latestSubscription;
                this.monthlyEnquiries = data.enquiryTrends;

                var monthlyEnquiriesSeries = this.monthlyEnquiries.map(function(data) {
                    return [data.month, data.total];
                });

                this.monthlyEnquiriesSeries = [
                    { 'name': 'Monthly enquiries', 'data': monthlyEnquiriesSeries },
                ];

                this.formattedVisitTrends = data.formattedVisitTrends;

                var monthlyVisitSeries = this.formattedVisitTrends.map(function(data) {
                    return [data.month, data.total];
                });

                this.monthlyVisitSeries=[
                    {'name':'Monthly enquiries', 'data': monthlyVisitSeries},
                ];

                this.topTenAgents = data.topTenAgents;
                this.topTenUsers = data.topTenUsers;
                this.topTenEnquiries = data.topTenEnquiries;
                this.listings = data.listings;
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
        }
    };
</script>
