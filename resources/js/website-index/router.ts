import { createRouter, createWebHistory } from 'vue-router';
import { useAppStore } from '../stores/website-index/appStore';
import { useWebsiteStore } from '../stores/websiteStore';

// Supported locales
const SUPPORTED_LOCALES = ['ar', 'en'] as const;
const DEFAULT_LOCALE = 'ar';

// Base routes without locale prefix (will be automatically localized)
const baseRoutes = [
    {
        path: '',
        name: 'index',
        component: () => import('../components/website-index/pages/Index.vue'),
        meta: {
            title: {
                ar: 'الرئيسية',
                en: 'Home'
            }
        }
    },
    {
        path: 'login',
        name: 'login',
        component: () => import('../components/website/pages/Login.vue'),
        meta: {
            title: {
                ar: 'تسجيل الدخول',
                en: 'Login'
            },
            guest: true
        }
    },
    {
        path: 'profile',
        name: 'profile',
        component: () => import('../components/website/pages/Profile.vue'),
        meta: {
            title: {
                ar: 'الملف الشخصي',
                en: 'Profile'
            },
            requiresAuth: true
        }
    },
    {
        path: 'contact',
        name: 'contact',
        component: () => import('../components/website/pages/Contact.vue'),
        meta: {
            title: {
                ar: 'اتصل بنا',
                en: 'Contact Us'
            }
        }
    },
    {
        path: 'user/info/:uuid',
        name: 'user-info',
        component: () => import('../components/website/pages/UserInfo.vue'),
        meta: {
            title: {
                ar: 'معلومات المستخدم',
                en: 'User Information'
            }
        }
    },
];

// Generate localized routes
function generateLocalizedRoutes() {
    const localizedRoutes: any[] = [];

    SUPPORTED_LOCALES.forEach(locale => {
        baseRoutes.forEach(route => {
            const localizedRoute = {
                path: `/${locale}${route.path ? '/' + route.path : ''}`,
                name: route.name ? `${route.name}-${locale}` : undefined,
                component: route.component,
                meta: {
                    ...route.meta,
                    locale,
                    title: typeof route.meta?.title === 'object' ? route.meta.title[locale] : route.meta?.title
                }
            };
            localizedRoutes.push(localizedRoute);
        });
    });

    return localizedRoutes;
}

// Create routes array with root redirect
const routes = [
    // Root redirect to default locale
    {
        path: '/',
        redirect: () => {
            // Check if user has a saved locale preference
            const savedLocale = localStorage.getItem('locale');
            if (savedLocale && SUPPORTED_LOCALES.includes(savedLocale as any)) {
                return `/${savedLocale}`;
            }
            return `/${DEFAULT_LOCALE}`;
        }
    },
    // Special route for user info without locale (for QR code compatibility)
    {
        path: '/user/info/:uuid',
        redirect: (to) => {
            const savedLocale = localStorage.getItem('locale') || DEFAULT_LOCALE;
            return `/${savedLocale}/user/info/${to.params.uuid}`;
        }
    },
    // Add all localized routes
    ...generateLocalizedRoutes(),
    // Catch-all for unmatched routes - redirect to default locale
    {
        path: '/:pathMatch(.*)*',
        redirect: (to) => {
            // Extract path without leading slash
            const path = to.path.substring(1);

            // If path starts with a locale, it's already handled
            const startsWithLocale = SUPPORTED_LOCALES.some(locale => path.startsWith(locale + '/') || path === locale);

            if (startsWithLocale) {
                // If it's a valid locale but route not found, redirect to home of that locale
                const locale = path.split('/')[0];
                return `/${locale}`;
            }

            // Otherwise, add default locale prefix
            return `/${DEFAULT_LOCALE}/${path}`;
        }
    }
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

// Comprehensive locale middleware (similar to mcamara)
router.beforeEach(async (to, from, next) => {
    // Extract locale from path
    const pathSegments = to.path.split('/').filter(Boolean);
    const firstSegment = pathSegments[0];

    // Check if first segment is a valid locale
    const isValidLocale = SUPPORTED_LOCALES.includes(firstSegment as any);

    // If no locale in URL, redirect to add default locale
    if (!isValidLocale && to.path !== '/') {
        const savedLocale = localStorage.getItem('locale') || DEFAULT_LOCALE;
        return next(`/${savedLocale}${to.path}`);
    }

    // Get locale from route meta or path
    const routeLocale = (to.meta.locale as 'ar' | 'en') || firstSegment || DEFAULT_LOCALE;

    // Validate locale
    if (!SUPPORTED_LOCALES.includes(routeLocale as any)) {
        return next(`/${DEFAULT_LOCALE}${to.path}`);
    }

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
    const title = to.meta.title || (routeLocale === 'ar' ? 'الرئيسية' : 'Home');
    document.title = `${title} - Pulse`;

    // Authentication guards
    const isAuthenticated = () => {
        const userDataStr = sessionStorage.getItem('user');
        return !!userDataStr;
    };

    // Guest only routes (like login) - redirect to profile if authenticated
    if (to.meta.guest && isAuthenticated()) {
        const profilePath = `/${routeLocale}/profile`;
        return next(profilePath);
    }

    // Protected routes - redirect to login if not authenticated
    if (to.meta.requiresAuth && !isAuthenticated()) {
        const loginPath = `/${routeLocale}/login`;
        return next(loginPath);
    }

    next();
});

export default router;

