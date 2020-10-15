require('./bootstrap');

import Vue from 'vue'
import router from './router'
import store from './store'
import App from './App.vue'
import VueToast from 'vue-toast-notification'
import { Alert, Button, Collapse, Dropdown, Tab, Modal, Popover, Scrollspy, Tooltip, Toast } from 'bootstrap'

Vue.use(VueToast)

store.dispatch('setUser').catch()

new Vue({
    router,
    store,
    render: h => h(App),
}).$mount('#app')
