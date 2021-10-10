import register from '../components/auth/register';
import login from '../components/auth/login';
import home from '../components/back_officer/home';
import manage from "../components/back_officer/clients/manage";
import zip_code from "../components/back_officer/services/zip_code";

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
    {
        path: '/register',
        component: register,
        name: 'register',
    },
    {
        path: '/manage',
        component: manage,
        name: 'manage',
    },
    {
        path: '/zip_code',
        component: zip_code,
        name: 'zip_code',
    }
];
