<template>
    <div>
       <!-- <span style="margin: 50px 20px; display: flex; align-items: center; justify-content: center; gap: 10px;"><i class="fas fa-circle-notch fa-spin" style="font-size: 20px;"></i> Loading ...</span> -->
       <div class="lds-ripple"><div></div><div></div></div>
    </div>
  </template>
  
  <script>
  export default {
    methods: {
    },
    mounted (){
  
    }
  };
  </script>
  
  <style>
  
  .lds-ripple,
  .lds-ripple div {
    box-sizing: border-box;
  }
  .lds-ripple {
    display: block;
    margin: auto;
    margin-top: 50px;
    width: 80px;
    height: 80px;
  }
  .lds-ripple div {
    position: absolute;
    border: 4px solid #FF4275;
    opacity: 1;
    border-radius: 50%;
    animation: lds-ripple 1s cubic-bezier(0, 0.2, 0.8, 1) infinite;
  }
  .lds-ripple div:nth-child(2) {
    animation-delay: -0.5s;
  }
  @keyframes lds-ripple {
    0% {
      top: 36px;
      left: 36px;
      width: 8px;
      height: 8px;
      opacity: 0;
    }
    4.9% {
      top: 36px;
      left: 36px;
      width: 8px;
      height: 8px;
      opacity: 0;
    }
    5% {
      top: 36px;
      left: 36px;
      width: 8px;
      height: 8px;
      opacity: 1;
    }
    100% {
      top: 0;
      left: 0;
      width: 80px;
      height: 80px;
      opacity: 0;
    }
  }
  </style>
  