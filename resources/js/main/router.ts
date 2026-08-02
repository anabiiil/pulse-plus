import {createRouter, createWebHistory} from 'vue-router';

const routes = [
    // Dashboard Index
    {
        path: '/dash',
        name: 'dashboard.index',
        component: () => import('../components/dashboard/Dashboard.vue'),
    },

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

    // Governorate routes with nested CRUD operations
    {
        path: '/dash/governorate',
        children: [
            {
                path: '',
                name: 'governorate.list',
                component: () => import('../components/dashboard/governorate/List.vue'),
            },
            {
                path: 'create',
                name: 'governorate.create',
                component: () => import('../components/dashboard/governorate/crud/Create.vue'),
            },
            {
                path: ':id/update',
                name: 'governorate.update',
                component: () => import('../components/dashboard/governorate/crud/Update.vue'),
            },
            {
                path: ':id/delete',
                name: 'governorate.delete',
                component: () => import('../components/dashboard/governorate/crud/Delete.vue'),
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

    // Sliders routes with nested CRUD operations
    {
        path: '/dash/sliders',
        children: [
            {
                path: '',
                name: 'sliders.list',
                component: () => import('../components/dashboard/sliders/List.vue'),
            },
            {
                path: 'create',
                name: 'sliders.create',
                component: () => import('../components/dashboard/sliders/crud/Create.vue'),
            },
            {
                path: ':id/edit',
                name: 'sliders.update',
                component: () => import('../components/dashboard/sliders/crud/Update.vue'),
            },
            {
                path: ':id/delete',
                name: 'sliders.delete',
                component: () => import('../components/dashboard/sliders/crud/Delete.vue'),
            },
        ],
    },

    // Users routes with nested CRUD operations
    {
        path: '/dash/users',
        children: [
            {
                path: '',
                name: 'users.list',
                component: () => import('../components/dashboard/users/List.vue'),
            },
            {
                path: 'create',
                name: 'users.create',
                component: () => import('../components/dashboard/users/crud/Create.vue'),
            },
            {
                path: ':id/show',
                name: 'users.show',
                component: () => import('../components/dashboard/users/crud/Show.vue'),
            },
            {
                path: ':id/edit',
                name: 'users.update',
                component: () => import('../components/dashboard/users/crud/Update.vue'),
            },
            {
                path: ':id/delete',
                name: 'users.delete',
                component: () => import('../components/dashboard/users/crud/Delete.vue'),
            },
        ],
    },

    // Settings routes (Edit only - no create or delete)
    {
        path: '/dash/settings',
        children: [
            {
                path: '',
                name: 'settings.list',
                component: () => import('../components/dashboard/settings/List.vue'),
            },
            {
                path: ':id/update',
                name: 'settings.update',
                component: () => import('../components/dashboard/settings/crud/Update.vue'),
            },
        ],
    },

    // Items routes with nested CRUD operations
    {
        path: '/dash/items',
        children: [
            {
                path: '',
                name: 'items.list',
                component: () => import('../components/dashboard/items/List.vue'),
            },
            {
                path: 'create',
                name: 'items.create',
                component: () => import('../components/dashboard/items/crud/Create.vue'),
            },
            {
                path: ':id/show',
                name: 'items.show',
                component: () => import('../components/dashboard/items/crud/Show.vue'),
                props: true,
            },
            {
                path: ':id/edit',
                name: 'items.update',
                component: () => import('../components/dashboard/items/crud/Update.vue'),
                props: true,
            },
            {
                path: ':id/delete',
                name: 'items.delete',
                component: () => import('../components/dashboard/items/crud/Delete.vue'),
                props: true,
            },
        ],
    },

    // Subscriptions routes with nested CRUD operations
    {
        path: '/dash/subscriptions',
        children: [
            {
                path: '',
                name: 'subscriptions.list',
                component: () => import('../components/dashboard/subscriptions/List.vue'),
            },
            {
                path: 'create',
                name: 'subscriptions.create',
                component: () => import('../components/dashboard/subscriptions/crud/Create.vue'),
            },
            {
                path: ':id/edit',
                name: 'subscriptions.update',
                component: () => import('../components/dashboard/subscriptions/crud/Update.vue'),
            },
            {
                path: ':id/delete',
                name: 'subscriptions.delete',
                component: () => import('../components/dashboard/subscriptions/crud/Delete.vue'),
            },
        ],
    },

    // Contact Messages routes
    {
        path: '/dash/contact-messages',
        children: [
            {
                path: '',
                name: 'contact-messages.list',
                component: () => import('../components/admin/pages/ContactMessages/List.vue'),
            },
        ],
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
