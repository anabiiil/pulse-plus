import { createRouter, createWebHistory } from 'vue-router';
import { useAppStore } from '../stores/website-index/appStore';
import { useWebsiteStore } from '../stores/websiteStore';

// Define routes without locale prefix
const routes = [
    // Arabic routes (default, no prefix)
    {
        path: '/',
        name: 'index',
        component: () => import('../components/website-index/pages/Index.vue'),
        meta: {
            title: 'الرئيسية',
            locale: 'ar'
        }
    },
    {
        path: '/login',
        name: 'login',
        component: () => import('../components/website/pages/Login.vue'),
        meta: {
            title: 'تسجيل الدخول',
            guest: true,
            locale: 'ar'
        }
    },
    {
        path: '/profile',
        name: 'profile',
        component: () => import('../components/website/pages/Profile.vue'),
        meta: {
            title: 'الملف الشخصي',
            requiresAuth: true,
            locale: 'ar'
        }
    },
    {
        path: '/contact',
        name: 'contact',
        component: () => import('../components/website/pages/Contact.vue'),
        meta: {
            title: 'اتصل بنا',
            locale: 'ar'
        }
    },

    // English routes (with /en prefix)
    {
        path: '/en',
        name: 'index-en',
        component: () => import('../components/website-index/pages/Index.vue'),
        meta: {
            title: 'Home',
            locale: 'en'
        }
    },
    {
        path: '/en/login',
        name: 'login-en',
        component: () => import('../components/website/pages/Login.vue'),
        meta: {
            title: 'Login',
            guest: true,
            locale: 'en'
        }
    },
    {
        path: '/en/profile',
        name: 'profile-en',
        component: () => import('../components/website/pages/Profile.vue'),
        meta: {
            title: 'Profile',
            requiresAuth: true,
            locale: 'en'
        }
    },
    {
        path: '/en/contact',
        name: 'contact-en',
        component: () => import('../components/website/pages/Contact.vue'),
        meta: {
            title: 'Contact Us',
            locale: 'en'
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
router.beforeEach(async (to, from, next) => {
    // Detect locale from route
    const routeLocale = to.meta.locale as 'ar' | 'en' || 'ar';

    // Get appropriate store based on route
    let store: any;
    if (to.path.includes('/login') || to.path.includes('/profile') || to.path.includes('/contact')) {
        store = useWebsiteStore();
    } else {
        store = useAppStore();
    }

    // Update locale if different from route locale
    if (store.locale !== routeLocale) {
        store.locale = routeLocale;
        store.updateHtmlAttributes();
        localStorage.setItem('locale', routeLocale);
    }

    // Update document title
    const title = to.meta.title || 'Pulse';
    document.title = `${title} - Pulse`;

    // Authentication guards
    const isAuthenticated = () => {
        // Check if user is authenticated by checking session
        // This is a simple check - you can make it more robust
        const userDataStr = sessionStorage.getItem('user');
        return !!userDataStr;
    };

    // Guest only routes (like login) - redirect to profile if authenticated
    if (to.meta.guest && isAuthenticated()) {
        const profilePath = routeLocale === 'en' ? '/en/profile' : '/profile';
        return next(profilePath);
    }

    // Protected routes - redirect to login if not authenticated
    if (to.meta.requiresAuth && !isAuthenticated()) {
        const loginPath = routeLocale === 'en' ? '/en/login' : '/login';
        return next(loginPath);
    }

    next();
});

export default router;


