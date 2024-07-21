import Messages from './pages/Messages.vue';

export default [
    { path: '/', redirect: '/dashboard' },

    {
        path: '/',
        name: 'messaging',
        component: Messages
    }
];
