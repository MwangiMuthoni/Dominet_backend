<template>
    <div>
        <div class="row justify-content-center" style="margin-top:50px;">
          <div class="col-sm-4">
            <div class="card login">
              <div class="card-body">
                <h3 class="mb-0">Forbiden</h3> 
                <h5 class="mt-0">You do not have sufficient permissions to access this resource</h5>
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