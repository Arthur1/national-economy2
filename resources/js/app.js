require('./bootstrap');

import Vue from 'vue'
import router from './router'
import store from './store'
import App from './App.vue'
import VueToast from 'vue-toast-notification'
import { Alert, Button, Collapse, Dropdown, Tab, Modal, Popover, Scrollspy, Tooltip, Toast } from 'bootstrap'
import { library } from '@fortawesome/fontawesome-svg-core'
import { faPlus, faUsers, faAngleDoubleRight } from '@fortawesome/free-solid-svg-icons'
import { faClock } from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

Vue.use(VueToast)

const icons = [
    faPlus,
    faUsers,
    faAngleDoubleRight,
    faClock
]
library.add(icons)
Vue.component('font-awesome-icon', FontAwesomeIcon)

store.dispatch('setUser').catch()

new Vue({
    router,
    store,
    render: h => h(App),
}).$mount('#app')
