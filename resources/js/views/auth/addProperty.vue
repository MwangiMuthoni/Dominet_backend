<template>
    <div class="pt-4" style="min-height: 100vh;">
      <div class="row pt-4 d-flex justify-content-center">
        

        <div class="col-sm-6" style="margin-top: 100px;">
            <h5 style="font-weight: bold; font-size:xx-large; color: #3e5164;">Add a property</h5>
          <div class="">
            <div class="card-body">
  
              <form action="" method="POST" @submit.prevent="save">
                    <div v-if="error!=null"><span class="text-danger" role="alert">{{error}}</span></div>

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" v-model="formData.name" required/>
                        <div v-if="errors.name"><span class="text-danger" role="alert">{{ errors.name[0] }}</span></div>
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-control" v-model="formData.description"></textarea>
                        <div v-if="errors.description"><span class="text-danger" role="alert">{{ errors.description[0] }}</span></div>
                    </div>

                    <div class="form-group">
                        <label>Location</label>
                        <input type="text" name="location" class="form-control" v-model="formData.location" />
                        <div v-if="errors.location"><span class="text-danger" role="alert">{{ errors.location[0] }}</span></div>
                    </div>

                    <div class="row g-1">
                        <div class="form-group col">
                            <label>Latitude</label>
                            <input type="text" name="latitude" class="form-control" v-model="formData.latitude" />
                            <div v-if="errors.latitude"><span class="text-danger" role="alert">{{ errors.latitude[0] }}</span></div>
                        </div>

                        <div class="form-group col">
                            <label>Longitude</label>
                            <input type="text" name="longitude" class="form-control" v-model="formData.longitude" />
                            <div v-if="errors.longitude"><span class="text-danger" role="alert">{{ errors.longitude[0] }}</span></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" name="image" class="form-control" v-on:change="onAttachmentSelected" />
                        <div v-if="errors.image"><span class="text-danger" role="alert">{{errors.image[0]}}</span></div>
                    </div>

                    <div class="">
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <button class="btn btn-sm btn-warning mt-2" :disabled="loading_submit"> <span v-if="loading_submit"><i class="fas fa-circle-notch fa-spin"></i></span> {{loading_submit ? 'Loading..' : 'Save'}}</button>
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
  
      export default {
          name:'addProperty',
          created(){
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
            formData: {
                name:'',
                description:'',
                location: '',
                latitude:'',
                longitude:'',
            }
        }),
        methods: {
            onAttachmentSelected(event) {
                const allowedFormats = ['png', 'jpg', 'webp', 'jpeg'];
                const selectedFile = event.target.files[0];

                const fileExtension = selectedFile.name.split('.').pop().toLowerCase();

                if (allowedFormats.includes(fileExtension)) {
                    this.formData.image = selectedFile;
                    this.errors.image = null;
                } else {
                    this.errors.image = 'Invalid file format. Please select a PNG, JPG, or WEBP file.';
                    event.target.value = null;
                    this.formData.image = null;
                }
            },
  
            save: async function (event) {
                this.loading_submit=true;
                var url='/api/property';
                
                let formData = new FormData();
                formData.append('name', this.formData.name)
                formData.append('description', this.formData.description)
                formData.append('location', this.formData.location)
                formData.append('latitude', this.formData.latitude)
                formData.append('longitude', this.formData.longitude)
                formData.append('image', this.formData.image)
        


                const data = await Network.store(url, formData);
                if(data.error){this.errors=data.error; this.loading_submit=false;}
                else{this.$router.push('/home/');}
            },
        },

      };


  </script>