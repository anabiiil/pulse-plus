import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    // Home page
    {
        path: '/',
        name: 'index',
        component: () => import('../components/website-index/pages/Index.vue'),
        meta: {
            title: 'Home'
        }
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior(to, _from, savedPosition) {
        if (savedPosition) {
            return savedPosition;
        } else if (to.hash) {
            return {
                el: to.hash,
                behavior: 'smooth',
            };
        } else {
            return { top: 0 };
        }
    },
});

// Navigation guards
router.beforeEach((to, _from, next) => {
    // Update document title
    const title = to.meta.title || 'Pulse';
    document.title = `${title} - Pulse`;

    next();
});

export default router;


