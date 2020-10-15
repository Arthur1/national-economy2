require('./bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router'
import router from './router'
import App from './App.vue'
import VueToast from 'vue-toast-notification'

Vue.use(VueToast)
Vue.use(VueRouter)

new Vue({
    router,
    render: h => h(App),
}).$mount('#app')
