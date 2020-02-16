/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');
window._ = require('lodash');
window,$ = window.jQuery = require('jquery');
import axios from 'axios'
import VueAxios from 'vue-axios'

Vue.use(VueAxios, axios)

Vue.config.productionTip = false
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('notification', require('./components/FormNotification.vue').default);
// const app = new Vue({
//     el: '#app',
// });
const app = new Vue({
    el: '#app',
    data: {
        submissions: '',
    },
    created(){
        axios.post('/notification/get').then(response => {
            this.submissions = response.data;
        });
        var userId = $('meta[name="userId"]').attr('content');
        Echo.private('App.User.' + userId).notification((notification) => {
            this.submissions.push(notification);
            console.log(notification);
        });
    }
    // created(){
    //     if (window.Laravel.userId){
    //         axios.post('/notification/submission/notification').then(response => {
    //             this.submissions = response.data;
    //             console.log(response.data)
    //         });
    //         Echo.private('App.User.'+window.Laravel.userId).notification((response)=>{
    //             data = {"data":response};
    //             this.submissions.push(data);
    //             console.log(response);
    //         });
    //     }
    // }
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// const app = new Vue({
//     el: '#app',
// });
