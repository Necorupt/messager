import './bootstrap';
import { createApp } from 'vue';
import routes  from '@/routes';
import Auth from '@/store/Auth.js';

import App from '@/App.vue';


const app = createApp(App);
app.use(routes);
app.use(Auth);
app.mount('#app');