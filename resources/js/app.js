


import Vue from "vue";
import {BootstrapVue} from 'bootstrap-vue';
import VueRouter from 'vue-router';
import routes from './routes';
import Vuelidate from "vuelidate";
import axios from 'axios';
import VueAxios from 'vue-axios';

Vue.use(Vuelidate);
Vue.use(VueAxios, axios);


import BaseComponent from "./components/BaseComponent";

require('./bootstrap');
Vue.use(BootstrapVue);
Vue.use(VueRouter)

const router = new VueRouter(routes);


Vue.mixin({
    methods:{
        userVerification(){
            let authToken = localStorage.getItem("qrCodeToken");

            if(authToken == null){
                return;
            }
            const AuthStr = "Bearer " + authToken;
            axios
              .get("api/user", { headers: { Authorization: AuthStr } })
              .then((response) => {
                console.log(response.data.id);
                if(response.data.id > 0){
                    this.$router.push("/user");
                }
              })
              .catch((error) => {
                console.log(error);
              });
        },
    }
})


const app = new Vue({
    el: '#app',
    router: router,
    components:{
        BaseComponent
    }
});


