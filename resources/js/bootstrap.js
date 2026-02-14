import axios from 'axios';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.withCredentials = true;

// Smart base URL detection based on current path
const isDashboard = window.location.pathname.startsWith('/dash');

if (isDashboard) {
    // Dashboard: Use /dashboard as base (relative path works)
    // Dashboard APIs are called like: axios.get('slider/list') → /dashboard/slider/list
    axios.defaults.baseURL = import.meta.env.VITE_DASHBOARD_API_URL || '/dashboard';
} else {
    // Website: Use origin only (full paths with /api/website/...)
    // Website APIs are called like: axios.post('/api/website/auth/login')
    axios.defaults.baseURL = import.meta.env.VITE_API_URL || window.location.origin;
}

const token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found. Check if it is correctly included in your Blade template.');
}

// Add interceptor to automatically add Accept-Language header
axios.interceptors.request.use((config) => {
    // Detect language from URL path or localStorage
    let locale = 'ar'; // default

    const path = window.location.pathname;
    if (path.startsWith('/en/') || path.startsWith('/en')) {
        locale = 'en';
    } else if (path.startsWith('/ar/') || path.startsWith('/ar')) {
        locale = 'ar';
    } else {
        // Fallback to localStorage
        const storedLocale = localStorage.getItem('locale');
        if (storedLocale && (storedLocale === 'en' || storedLocale === 'ar')) {
            locale = storedLocale;
        }
    }

    config.headers['Accept-Language'] = locale;
    return config;
}, (error) => {
    return Promise.reject(error);
});

