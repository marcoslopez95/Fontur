import { createApp } from 'vue'
import App from './App.vue'
import './index.css'
import {Router} from './routes/index'
import axios from 'axios'
import 'vue-select/dist/vue-select.css';
import vSelect from 'vue-select'


axios.defaults.baseURL = import.meta.env.VITE_API;
createApp(App)
.use(Router)
.component('v-select', vSelect)
.mount('#app')
