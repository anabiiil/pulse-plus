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

    // Country routes with nested CRUD operations
    {
        path: '/dash/country',
        children: [
            {
                path: '',
                name: 'country.list',
                component: () => import('../components/dashboard/country/List.vue'),
            },
            {
                path: 'create',
                name: 'country.create',
                component: () => import('../components/dashboard/country/crud/Create.vue'),
            },
            {
                path: ':id/update',
                name: 'country.update',
                component: () => import('../components/dashboard/country/crud/Update.vue'),
                props: true,
            },
            {
                path: ':id/delete',
                name: 'country.delete',
                component: () => import('../components/dashboard/country/crud/Delete.vue'),
                props: true,
            },
            {
                path: 'import',
                name: 'country.import',
                component: () => import('../components/dashboard/country/crud/Import.vue'),
            },
        ],
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
