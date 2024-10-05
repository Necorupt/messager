import '../css/app.css'

import './bootstrap';
import { createApp } from 'vue';
import routes  from '@/routes';
import store  from '@/store';

import App from '@/App.vue';


const app = createApp(App);
app.use(routes);
app.use(store);
app.mount('#app');