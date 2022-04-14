import { createApp } from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import Datepicker from '@vuepic/vue-datepicker'
import App from './App.vue'
import router from './router'

const app = createApp(App)

app.use(router)

axios.defaults.baseURL = import.meta.env.VITE_API_URL + "/"
app.use(VueAxios, axios)
app.provide('axios', app.config.globalProperties.axios)

app.component('Datepicker', Datepicker)

app.mount('#app')
