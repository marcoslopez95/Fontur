import { createApp } from 'vue'
import App from './App.vue'
import './index.css'
import {Router} from './routes/index'
import axios from 'axios'

axios.defaults.baseURL = import.meta.env.VITE_API;
createApp(App)
.use(Router)
.mount('#app')
