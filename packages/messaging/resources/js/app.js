import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
import axios from 'axios';

window.Pusher = Pusher;
window.Echo = Echo;

const token = document.head.querySelector("meta[name='csrf-token']");

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

const http = axios.create({
    baseURL: '/messaging/api'
});

import App from './App.vue';

import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import routes from './routes';

window.Messaging.basePath = `/${window.Messaging.path}`;

let routerBasePath = `${window.Messaging.basePath}/`;

if (window.Messaging.path === '' || window.Messaging.path === '/') {
    routerBasePath = '/';
    window.Messaging.basePath = '';
}

const router = createRouter({
    history: createWebHistory(routerBasePath),
    routes: routes,
    linkActiveClass: 'active'
});

const app = createApp(App);
app.use(router);
app.provide('http', http);
app.mount('#messaging');
