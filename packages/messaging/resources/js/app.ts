import axios from 'axios';
let token = document.head.querySelector("meta[name='csrf-token']") as any;

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

const http = axios.create({
    baseURL: '/messaging/api'
});

import Messages from './pages/Messages.vue';

import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';

window.Messaging.basePath = `/${window.Messaging.path}`;

let routerBasePath = `${window.Messaging.basePath}/`;

if (window.Messaging.path === '' || window.Messaging.path === '/') {
    routerBasePath = '/';
    window.Messaging.basePath = '';
}

const router = createRouter({
    history: createWebHistory(routerBasePath),
    routes: [],
    linkActiveClass: 'active'
});

const app = createApp(Messages);
app.use(router);
app.provide('http', http);
app.mount('#messaging');
