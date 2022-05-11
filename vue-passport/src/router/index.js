// import vue router

import {
    createRouter,
    createWebHistory
}
from 'vue-router'

//const a routes
const routes = [{
    path: '/login',
    name: 'login',
    component: () => import( /* webpackChunkName: "login" */ '@/views/auth/Login.vue')
}, {
    path: '/register',
    name: 'register',
    component: () => import( /* webpackChunkName: "register" */ '@/views/auth/Register.vue')
}, {
    path: '/dashboard',
    name: 'dashboard',
    component: () => import( /* webpackChunkName: "dashboard" */ '@/views/dashboard/Index.vue')
}]


// create router
const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router