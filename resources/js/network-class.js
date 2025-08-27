import axios from 'axios';
import router from './router';
export default class Network{

    static login(formData){
        axios.get('/sanctum/csrf-cookie').then(response => {
              axios.post('/api/login', formData).then(response => {
                   localStorage.setItem("auth", true);
                   localStorage.setItem("user", JSON.stringify(response.data.user));
                   localStorage.setItem("token", response.data.token.plainTextToken);
                   router.push({name:"home"})
                }).catch(response=>resolve(response.data));
            });
    }

    static logout(){
        axios.get('/sanctum/csrf-cookie').then(response => {
              axios.get('/api/logout', { headers: {"Authorization" : `Bearer ${localStorage.getItem("token")}`}}).then(response => {
                    localStorage.removeItem('token');
                    localStorage.removeItem('user');
                    localStorage.removeItem('auth');
                    this.$store.commit('getUser');
                    router.push('/login');//welcome
                }).catch((error) =>{ 
                  this.globalError='Logout was unsuccessful';
                });
            });
    }

    static async checkAuth(){
        const data = await Network.get('/api/checkAuth');
        if(data.error){ 
            localStorage.removeItem('token');
            localStorage.removeItem('user');
            localStorage.removeItem('auth');
            return false;}
        else{
            if(data['success']==true){
                localStorage.setItem("auth", true);
                localStorage.setItem("user", JSON.stringify(data.user));
                return true;
            }
            else{
                localStorage.removeItem('token');
                localStorage.removeItem('user');
                localStorage.removeItem('auth');
                return false;
            }
        }
    }

    static get(url){
        return new Promise(function(resolve, reject) {
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.get(url, { headers: {"Authorization" : `Bearer ${localStorage.getItem("token")}`}})
                .then(response=>resolve(response.data))
                .catch(err => reject(err))
            });
        });
    }

    static store(url, formData){
        return new Promise(function(resolve, reject) {
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post(url , formData,  { headers: {"Authorization" : `Bearer ${localStorage.getItem("token")}`}})
                .then(response=>resolve(response.data))
                .catch(err => resolve(err))
            });
        });
    }
    static storeUpload(url, formData){
        return new Promise(function(resolve, reject) {
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post(url , formData,  { headers: {"Authorization" : `Bearer ${localStorage.getItem("token")}`,  
                    'content-type': 'multipart/form-data'}})
                .then(response=>resolve(response.data))
                .catch(err => reject(err))
            });
        });
    }
    static update(url, formData){
         return new Promise(function(resolve, reject) {
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.put(url , formData,  { headers: {"Authorization" : `Bearer ${localStorage.getItem("token")}`}})
                .then(response=>resolve(response.data))
                .catch(err => reject(err))
            });
        });

    }

    static delete(url){
            return new Promise(function(resolve, reject) {
                axios.get('/sanctum/csrf-cookie').then(response => {
                                axios.delete(url, { headers: {"Authorization" : `Bearer ${localStorage.getItem("token")}`}})
                    .then(response=>resolve(response.data))
                     .catch(err => reject(err))
                });
            });
    }   
}