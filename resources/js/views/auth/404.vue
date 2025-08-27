<template>
    <div>
        <div class="row justify-content-center" style="margin-top:50px;">
          <div class="col-sm-4">
            <div class="card login">
              <div class="card-body">
                <h1 class="text-center">404</h1>
                <h3 class="mb-0 text-center">Opps! Kwani umepotea?</h3> 
                <h5 class="mt-0 text-center">The page you are looking for is no longer here or never existed in the first place (mazee, najua). Kindly use the links above to go back to browsing.</h5>
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
        name:'forbiden',
        components: {},
        created(){
        },
        mounted(){
        },
      data:() => ({
        errors:[],
      }),
      methods: {},
    };
    </script>