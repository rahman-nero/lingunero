import {createRouter, createWebHistory} from 'vue-router'
import {getToken, getUser} from '@/api/auth'
import HomeView from '../views/HomeView.vue'
import LoginView from '../views/LoginView.vue'
import RegisterView from '../views/RegisterView.vue'


const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            name: 'home',
            component: HomeView,
            meta: {requiresAuth: true},
        },
        {
            path: '/login',
            name: 'login',
            component: LoginView
        },
        {
            path: '/register',
            name: 'register',
            component: RegisterView
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