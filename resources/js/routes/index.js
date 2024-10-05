import { createRouter, createWebHistory } from "vue-router";

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: "/",
            name: "MainLayout",
            component: () => import('@/layouts/MainLayout.vue'),
            children: [
                {
                    path: '/',
                    name: 'index',
                    component: () => import('@/views/Index.vue')
                },
                {
                    path: '/register',
                    name: 'register',
                    component: () => import('@/views/Register.vue')
                },
                {
                    path: '/login',
                    name: 'login',
                    component: () => import('@/views/Login.vue')
                },
                {
                    path: '/chat/:id',
                    name: 'chat',
                    component: () => import('@/views/Chat.vue')
                }
            ]
        },
    ]
})

export default router