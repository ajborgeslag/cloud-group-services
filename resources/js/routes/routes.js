import login from '../components/auth/loguin';
import home from '../components/back_officer/home';

export const routes = [
    {
        path: '/home',
        component: home,
        name: 'home',
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/login',
        component: login,
        name: 'login',
    },
];
