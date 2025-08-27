<template>
    <div class="pt-4" style="min-height: 100vh;">
        <div class="row justify-content-center" style="margin-top: 100px;">
            <div class="col-lg-8 mt-4" style="text-align: center;">
                <h4 style="font-size: 30px !important;">Update your Package</h4>
                <p>You have reached your listing limit for <span style="font-weight: bold;">{{user?.company_subscription?.subscription_package_title}}</span> subscription!</p>
                <p>Please update to next package</p>
            </div>
            <div class="col-lg-8 mt-4">
                <div class="row position-relative">
                    <div class="col-lg-1" style="border-bottom: 2px solid rgba(243, 243, 244, .5);"></div>
                    <div class="col-lg-4" 
                         :style="{ borderBottom: !showPeriod ? '2px solid #1a5ac4' : '2px solid rgba(243, 243, 244, .5)', cursor: 'pointer' }"
                         @click="toggleShowPeriod">
                        <div class="w-100" style="display: flex; flex-direction: column; text-align: center;">
                            <p :style="{ color: showPeriod ? '#0d56cc' : '#8a95a7' }"></p>
                        </div>
                    </div>
                    <div class="col-lg-1" style="border-right: 2px solid rgba(243, 243, 244, .5); border-bottom: 2px solid rgba(243, 243, 244, .5);"></div>
                    <div class="col-lg-1" style="border-bottom: 2px solid rgba(243, 243, 244, .5);"></div>
                    <div class="col-lg-4" 
                         :style="{ borderBottom: !showPeriod ? '2px solid #1a5ac4' : '2px solid rgba(243, 243, 244, .5)', cursor: 'pointer' }"
                         @click="toggleShowPeriod">
                        <div class="w-100" style="display: flex; flex-direction: column; text-align: center;">
                            <p :style="{ color: showPeriod ? '#0d56cc' : '#8a95a7' }"></p>
                        </div>
                    </div>
                    <div class="col-lg-1" style="border-bottom: 2px solid rgba(243, 243, 244, .5);"></div>
                </div>

                <div class="row g-2 pt-2">
                    <div class="col-sm-4" v-for="pkg in packages" :key="pkg.id">
                        <div class="card h-100">
                            <div class="card-body d-flex flex-column">
                            <h4>{{ pkg.title }}</h4>
                            <p style="font-weight: bold;">Upto {{ pkg.no_of_listings }} listings</p>
                            <p>{{ pkg.description }}</p>
                            <h4 style="margin-top: auto;">{{ pkg.price }}</h4>
                            <button class="btn btn-sm" style="background-color: #1659ca; color: white; margin-top: auto;" @click.prevent="goToAddUser(pkg)" :disabled="pkg.loading">
                                <span v-if="pkg.loading"><i class="fas fa-circle-notch fa-spin"></i></span> {{pkg.loading ? 'Loading..' : 'Select'}}
                            </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="modal fade" id="advanceModal" tabindex="-1" role="dialog" aria-labelledby="advanceModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="advanceModalLabel">{{ package.name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
                </div>
                <div class="modal-body">
                    {{ package.description }}
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
    name: 'updateSubscription',

    created() {
        this.$store.commit('getUser');
        this.getPackage();
    },
    data: () => ({
        loading_submit: false,
        loading_submit2: false,
        loading_submit3: false,
        loading: false,
        error_message: false,
        errors: [],
        showPeriod: true,
        edit_id: '',
        package: [],
        packages: [],
        id: '',
        error: '',
        formData: {}
    }),
    methods: {
        toggleShowPeriod() {
            this.showPeriod = !this.showPeriod;
        },

        setEdit(packageDeal) {
            this.edit_id = packageDeal.id;
            this.package = packageDeal;
        },

        async goToAddUser(pkg) {
            pkg.loading = true;
            var url = '/api/addPackage';
            try {
                const data = await Network.storeUpload(url);
                if (data.error) {
                    this.errors = data.error;
                } else if (data.error_message) {
                    this.error_message = data.error_message;
                } else {
                    localStorage.setItem("user", JSON.stringify(data.data));
                    this.$store.commit('getUser');
                    this.$router.push('/make-payment/' + pkg.id);
                }
            } catch (error) {
                console.error(error);
            } finally {
                pkg.loading = false;
            }
        },

        async getPackage() {
            const data = await Network.get('/api/packages/');
            this.packages = data.packages.map(pkg => ({ ...pkg, loading: false }));
        },
    },
    computed: {
        user() {
            return this.$store.state.user;
        },
    },
};
</script>
