<template>
    <div>
         <button type="button" class="btn btn-sm whiteTitle" data-bs-toggle="modal" data-bs-target="#emailModal"><i class="fa fa-envelope"></i> Email</button>
                <div class="modal fade" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="emailModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="emailModalLabel">Send email</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                      </div>
                      <div class="modal-body">
                        <form action="#" @submit.prevent="send">
                          <div class="form-group">
                            <label>To</label>
                            <div class="input-group">
                                <input type="text" name="to" class="form-control" v-model="formData.to" />
                                 <div class="input-group-append" v-on:click="toggleCC()">
                                    <span class="input-group-text" style="border-top-left-radius: 0px; border-bottom-left-radius: 0px;"><i class="fa fa-plus"></i>  Add cc</span>
                                </div>
                            </div>
                            <div v-if="errors.to"><span class="text-danger" role="alert">{{errors.to[0]}}</span></div>
                          </div>
                          <div class="form-group" v-if="cc">
                            <label>CC</label>
                            <input type="text" name="cc" class="form-control" v-model="formData.cc" />
                            <div v-if="errors.cc"><span class="text-danger" role="alert">{{errors.cc[0]}}</span></div>
                          </div>
                          <div class="form-group">
                            <label>Subject</label>
                            <input type="text" name="subject" class="form-control" v-model="formData.subject" />
                            <div v-if="errors.subject"><span class="text-danger" role="alert">{{errors.subject[0]}}</span></div>
                          </div>
                          <div class="form-group">
                            <label>Message</label>
                            <textarea name="message" class="form-control trumbowyg" v-model="formData.message"></textarea>
                            <div v-if="errors.message"><span class="text-danger" role="alert">{{errors.message[0]}}</span></div>
                          </div>

                          <div v-if="has_attachment==true" class="mt-3"><i class="fa-solid fa-paperclip"></i> {{subject}}</div>
                        </form>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-warning" :disabled="loading_submit" @click="send"> <span v-if="loading_submit"><i class="fas fa-circle-notch fa-spin"></i></span> {{loading_submit ? 'Loading..' : 'Send email'}}</button>
                      </div>
                    </div>
                  </div>
                </div>
    </div>
</template>

  <script>
    import Network from "../network-class";

    export default {
    name:'letterfooter',
    props: {
      to: String,
      subject: String,
      document: String,
      document_id: Number,
      has_attachment: Boolean,
    },
    created(){
        this.$store.commit('getUser');
        this.$store.commit('getcompany');
        this.formData.to=this.to;
        this.formData.subject=this.subject;
        this.formData.has_attachment=this.has_attachment;
        this.formData.document=this.document;
        this.formData.document_id=this.document_id;
        this.formData.message='Hello, <br>Kindly find the attached '+this.document+' for your review.<br><br> Kind regards,<br>'+this.user.name+',<br> '+this.company.name+'.';
        this.cc=false;
        },
    mounted() {
            $('.trumbowyg').trumbowyg();
        },
    data:() => ({
            errors:[],
            cc:false,
            loading_submit:false,loading: false,
            formData:{
                        to:'',
                        cc:null,
                        subject:'',
                        message:'',
                        has_attachment:'',
                        document:'',
                        document_id:'',
                    },
          }),
      methods: {
        send: async function (event) {
              this.loading_submit=true;
              var url='/api/sendEmail';
              if (!this.cc) {delete this.formData.cc;}
              const data = await Network.store(url, this.formData);
              if(data.error){this.errors=data.error; this.loading_submit=false;}
              else{this.loading_submit=false;
                  // this.formData=[];
                  $('#emailModal').modal('hide');}
            },
            toggleCC() {
                this.cc = !this.cc;
                if(this.cc ==false){
                    this.formData.cc=null;
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
        },
      
    }
  </script>