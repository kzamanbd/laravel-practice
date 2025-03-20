import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;
window.Echo = Echo;

const http = window.axios;

import App from './App.vue';

import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import routes from './routes';

const router = createRouter({
    history: createWebHistory('/messaging'),
    routes: routes,
    linkActiveClass: 'active'
});

const app = createApp(App);
app.use(router);
app.provide('http', http);
app.mount('#messaging');

