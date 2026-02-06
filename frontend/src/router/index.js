import {createRouter, createWebHistory} from 'vue-router'
import {getToken, getUser} from '@/api/auth'
import Home from '../pages/Home.vue'
import Login from '../pages/Login.vue'
import Register from '../pages/Register.vue'
import Grammar from '../pages/Grammar.vue'
import Practice from '../pages/Practice.vue'
import Words from '../pages/Words.vue'


const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home,
            meta: {requiresAuth: true},
        },
        {
            path: '/grammar',
            name: 'grammar',
            component: Grammar,
            meta: {requiresAuth: true},
        },
        {
            path: '/practice',
            name: 'practice',
            component: Practice,
            meta: {requiresAuth: true},
        },
        {
            path: '/words',
            name: 'words',
            component: Words,
            meta: {requiresAuth: true},
        },
        {
            path: '/login',
            name: 'login',
            component: Login
        },
        {
            path: '/register',
            name: 'register',
            component: Register
        },
    ],
})

router.beforeEach(async (to) => {
    const token = getToken()

    if (to.meta.requiresAuth) {
        if (!token) {
            return {name: 'login'}
        }

        try {
            await getUser()
        } catch (error) {
            return {name: 'login'}
        }
    }
})

export default router