import { RouterOptions } from 'vue-router';
import Messages from './pages/MessagesView.vue';
import NotFound from './pages/PageNotFound.vue';

export default [
    { path: '/', redirect: '/dashboard' },

    {
        path: '/dashboard',
        name: 'messaging',
        component: Messages
    },
    {
        name: 'NotFound',
        path: '/:catchAll(.*)',
        component: NotFound
    }
] as RouterOptions['routes'];
