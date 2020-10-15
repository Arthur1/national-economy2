import VueRouter from 'vue-router'

import Index from '../views/Index.vue'

const routes = [
    {
        path: '/',
        name: 'index',
        component: Index,
        meta: {
            title: 'TOP',
            needsAuth: false
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
