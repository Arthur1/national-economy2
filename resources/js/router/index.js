import VueRouter from 'vue-router'

import Index from '../views/Index.vue'
import Login from '../views/Login.vue'
import Register from '../views/Register.vue'
import NotFound from '../views/NotFound.vue'

const routes = [
    {
        path: '/',
        name: 'index',
        component: Index,
        meta: {
            title: 'TOP',
            needsAuth: false,
            hasHeader: true
        }
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: {
            title: 'ログイン',
            needsAuth: false,
            hasHeader: false
        }
    },
    {
        path: '/register',
        name: 'register',
        component: Register,
        meta: {
            title: 'ユーザ登録',
            needsAuth: false,
            hasHeader: false
        }
    },
    {
        path: '*',
        name: 'not_found',
        component: NotFound,
        meta: {
            title: 'Not Found',
            needsAuth: false,
            hasHeader: true
        }
    }
]

const router = new VueRouter({
    mode: 'history',
    routes,
    scrollBehavior: (to, from, savedPosition) => savedPosition || { x: 0, y: 0 }
})

router.beforeEach((to, from, next) => {
    document.title = to.meta.title + ' | National Economy Online'
    next()
})

export default router
