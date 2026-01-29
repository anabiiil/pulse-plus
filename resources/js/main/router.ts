import {createRouter, createWebHistory} from 'vue-router';

const routes = [
    // Slider routes with nested CRUD operations
    {
        path: '/dash/slider',
        children: [
            {
                path: '',
                name: 'slider.list',
                component: () => import('../components/dashboard/slider/List.vue'),
            },
            {
                path: 'create',
                name: 'slider.create',
                component: () => import('../components/dashboard/slider/crud/Create.vue'),
            },
            {
                path: ':id/update',
                name: 'slider.update',
                component: () => import('../components/dashboard/slider/crud/Update.vue'),
                props: true,
            },
            {
                path: ':id/delete',
                name: 'slider.delete',
                component: () => import('../components/dashboard/slider/crud/Delete.vue'),
                props: true,
            },
        ],
    },


    // Nationality routes with nested CRUD operations
    {
        path: '/dash/nationality',
        children: [
            {
                path: '',
                name: 'nationality.list',
                component: () => import('../components/dashboard/nationality/List.vue'),
            },
            {
                path: 'create',
                name: 'nationality.create',
                component: () => import('../components/dashboard/nationality/crud/Create.vue'),
            },
            {
                path: ':id/update',
                name: 'nationality.update',
                component: () => import('../components/dashboard/nationality/crud/Update.vue'),
            },
            {
                path: ':id/delete',
                name: 'nationality.delete',
                component: () => import('../components/dashboard/nationality/crud/Delete.vue'),
            },
        ],
    },

    // Services routes with nested CRUD operations
    {
        path: '/dash/services',
        children: [
            {
                path: '',
                name: 'services.list',
                component: () => import('../components/dashboard/services/List.vue'),
            },
            {
                path: 'create',
                name: 'services.create',
                component: () => import('../components/dashboard/services/crud/Create.vue'),
            },
            {
                path: ':id/edit',
                name: 'services.update',
                component: () => import('../components/dashboard/services/crud/Update.vue'),
            },
            {
                path: ':id/delete',
                name: 'services.delete',
                component: () => import('../components/dashboard/services/crud/Delete.vue'),
            },
        ],
    },

    // Products routes with nested CRUD operations
    {
        path: '/dash/products',
        children: [
            {
                path: '',
                name: 'products.list',
                component: () => import('../components/dashboard/products/List.vue'),
            },
            {
                path: 'create',
                name: 'products.create',
                component: () => import('../components/dashboard/products/crud/Create.vue'),
            },
            {
                path: ':id/edit',
                name: 'products.update',
                component: () => import('../components/dashboard/products/crud/Update.vue'),
            },
            {
                path: ':id/delete',
                name: 'products.delete',
                component: () => import('../components/dashboard/products/crud/Delete.vue'),
            },
        ],
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
