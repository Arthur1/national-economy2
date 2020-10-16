import Vue from 'vue'
import VueRouter from 'vue-router'
import store from '../store'

import Index from '../views/Index.vue'
import Login from '../views/Login.vue'
import Register from '../views/Register.vue'
import Home from '../views/Home.vue'
import CreateGame from '../views/CreateGame.vue'
import NotFound from '../views/NotFound.vue'

Vue.use(VueRouter)

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
        path: '/home',
        name: 'home',
        component: Home,
        meta: {
            title: 'Home',
            needsAuth: true,
            hasHeader: true
        }
    },
    {
        path: '/create_game',
        name: 'create_game',
        component: CreateGame,
        meta: {
            title: 'ゲーム作成',
            needsAuth: true,
            hasHeader: true
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

const nextAuth = (to, from, next) => {
    if (store.getters.isLoggedIn) {
        next()
    } else {
        next({ name: 'login', query: { redirect: to.fullPath }})
    }
}

router.beforeEach((to, from, next) => {
	if (to.matched.some(record => record.meta.needsAuth)) {
        if (! store.state.isInitialized) {
            const unwatch = store.watch(state => state.isInitialized, () => {
                unwatch()
                nextAuth(to, from, next)
            })
        } else {
            nextAuth(to, from, next)
        }
    } else {
        next()
    }
})

export default router
