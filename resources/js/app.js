require('./bootstrap');

import Vue from 'vue'
import router from './router'
import App from './App.vue'
import VueToast from 'vue-toast-notification'

Vue.use(VueToast)

new Vue({
    router,
    render: h => h(App),
}).$mount('#app')
