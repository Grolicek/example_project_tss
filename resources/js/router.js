import {createRouter, createWebHistory} from "vue-router";
import AppLayout from "./layouts/AppLayout.vue";

const routes = [
    {
        path: '/',
        component: AppLayout,
        children: [
            {
                name: 'people',
                path: 'people',
                component: () => import('./pages/people/Index.vue'),
            },
            {
                name: 'people-edit',
                path: 'people/:id',
                component: () => import('./pages/people/Edit.vue'),
            },
        ]
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
