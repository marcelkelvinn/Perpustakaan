import { createApp } from 'vue';
import './style.css';
import App from './App.vue';
import axios from 'axios';
import router from './router';

// Set default base URL untuk Axios
axios.defaults.baseURL = 'http://localhost:8000/api'; 

// Buat aplikasi Vue
const app = createApp(App);

// Tambahkan axios sebagai properti global
app.config.globalProperties.$axios = axios;

// Tambahkan router ke aplikasi
app.use(router);
app.mount('#app');