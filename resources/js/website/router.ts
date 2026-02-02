import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    // Home page
    {
        path: '/',
        name: 'home',
        component: () => import('../components/website/pages/Home.vue'),
    },

    // About page
    {
        path: '/about',
        name: 'about',
        component: () => import('../components/website/pages/About.vue'),
    },

    // Services listing
    {
        path: '/services',
        name: 'services',
        component: () => import('../components/website/pages/Services.vue'),
    },

    // Service detail
    {
        path: '/services/:id',
        name: 'service.detail',
        component: () => import('../components/website/pages/ServiceDetail.vue'),
        props: true,
    },

    // Products listing
    {
        path: '/products',
        name: 'products',
        component: () => import('../components/website/pages/Products.vue'),
    },

    // Product detail
    {
        path: '/products/:id',
        name: 'product.detail',
        component: () => import('../components/website/pages/ProductDetail.vue'),
        props: true,
    },

    // Contact page
    {
        path: '/contact',
        name: 'contact',
        component: () => import('../components/website/pages/Contact.vue'),
    },

    // 404 Not Found
    {
        path: '/:pathMatch(.*)*',
        name: 'not-found',
        component: () => import('../components/website/pages/NotFound.vue'),
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition;
        } else {
            return { top: 0 };
        }
    },
});

export default router;
