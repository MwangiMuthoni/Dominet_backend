<template>
    <div class="row justify-content-center pt-4" style="min-height: 100vh;">
      <div class="col-sm-6 text-center" style="margin-top: 100px;">
        <h2 style="font-weight: bold; font-size:xx-large; color: #3e5164; text-align:center;">Check your email for a code</h2>
  
        <p>We’ve sent a 6-character code to {{ storedUser?.email }}. The code expires shortly, so please enter it soon.</p>
  
        <div class="mt-3">
          <div class="parent">
            <div class="child">
              <form style="display: flex; gap: 10px; justify-content: center;" @submit.prevent="sendDataToAPI">
                <input
                  v-for="(n, index) in code"
                  :key="index"
                  type="text"
                  pattern="\d*"
                  :id="'input_' + index"
                  maxlength="1"
                  style="width: 45px; height: 45px"
                  v-model="code[index]"
                  @input="handleInput"
                  @keydown.delete="handleDelete"
                  @paste="onPaste"
                  :tabindex="index === 0 ? 1 : 0"
                />
              </form>
                    </div>
                </div>
            </div>
        <p class="mt-3" style="color: red;" id="errorMessage">{{ errorMessage }}</p>
        <p class="mt-3" style="color: green;" id="successMessage">{{ successMessage }}</p>
        <p class="mt-3">Can’t find your codes? Check your spam folder!</p>
        <p style="display:none; align-items: center; justify-content: center;" id="spin1"><span><i class="fas fa-circle-notch fa-spin"></i> Loading ...</span></p>
        <div class="mt-2">
          <a class="mt-2 mb-3 w-100" :disabled="loading_submit" @click.prevent="requestAnotherCode">
            {{loading_submit ? 'Loading..' : 'Didnt receive your code! Resend.'}}
          </a>
        </div>

        <div class="mt-2">
          <h5><router-link to="/change-email">Wish to change email?</router-link></h5>
        </div>
      </div>
    </div>
</template>
  
  
<script setup>
    import { ref, onMounted } from 'vue';
    import Network from "../../network-class";
    let code = Array(6).fill('');
    let dataFromPaste;
    var loading_submit = false;
    var errorMessage = '';
    var successMessage = '';


    import router from '../../router';
    
    const handleInput = (event) => {
        let currentActiveElement = event.target;

        const nextInput = currentActiveElement.nextElementSibling;
        if (nextInput && event.inputType === "insertText") {
            nextInput.focus();
        }

        if (event.inputType === "insertFromPaste" && dataFromPaste) {
            for (const char of dataFromPaste) {
            const id = parseInt(currentActiveElement.id.split("_")[1]);
            currentActiveElement.value = char;
            code[id] = char;
            const nextInput = currentActiveElement.nextElementSibling;
            if (nextInput) {
                currentActiveElement = nextInput;
            }
            }

            if (currentActiveElement.id === `input_${code.length - 1}`) {
            sendDataToAPI();
            }
        }

        if (currentActiveElement.id === `input_${code.length - 1}`) {
            sendDataToAPI();
        }
        };

    
    const handleDelete = (event) => {
        const value = event.target.value;
        let currentActiveElement = event.target;
        if (!value) {
        const prevInput = currentActiveElement.previousElementSibling;
        if (prevInput) {
            prevInput.focus();
        }
        }
    };
    
    const onPaste = (event) => {
        dataFromPaste = event.clipboardData?.getData("text").trim().split("");

        if (event.target.id === `input_${code.length - 1}`) {
        sendDataToAPI();
        }
    };
    
    const sendDataToAPI = async () => {
        loading_submit = true;
        errorMessage = null;
        successMessage = null;

                
        const spinElement = document.getElementById('spin1');
        spinElement.style.display = 'flex';

        const enteredCode = code.join('');
        var url = '/api/confirm-email';

        let formData = new FormData();
        formData.append('entered_code', enteredCode);

        try {
            const data = await Network.store(url, formData);
            if (data.error) {
            errorMessage = data.error; 
            } else if (data.error_message) {
            spinElement.style.display = 'none';
            errorMessage = data.error_message;
            } else {
            loading_submit = false;
            spinElement.style.display = 'none';
            router.push('/home');
            }
        } catch (error) {
            console.error('Error sending email confirmation:', error);
            errorMessage = 'An unexpected error occurred. Please try again later.';
        }
    };



    const storedUser = JSON.parse(window.localStorage.getItem('user'));

    const requestAnotherCode = async () => {

        loading_submit = true;
        errorMessage = null;
        successMessage = null;
        
        const spinElement = document.getElementById('spin1');
        spinElement.style.display = 'flex';

        var url='/api/request-email-code';

        const data = await Network.get(url);
        console.log(data);

        if(data.error){
            console.log(data.error);
            loading_submit = false;
        }
        else if(data.error_message){
            loading_submit = false;
            errorMessage = data.error;

            const errorElement = document.getElementById('errorMessage');
            errorElement.innerHTML = data.error;
            spinElement.style.display = 'none';
        }
        else{
            loading_submit = false;
            successMessage = data.message;

            const successElement = document.getElementById('successMessage');
            successElement.innerHTML = data.message;
            spinElement.style.display = 'none';
        }
    };

    onMounted(() => {
        const firstInput = document.getElementById('input_0');
        if (firstInput) {
            firstInput.focus();
        }
    });

</script>


  