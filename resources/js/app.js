require('./bootstrap');
import router from './router'

window.Vue = require('vue').default;
import Toaster from 'v-toaster'

import 'v-toaster/dist/v-toaster.css'

Vue.use(Toaster, { timeout: 5000 })

const app = new Vue({
    el: '#app',
    router
});