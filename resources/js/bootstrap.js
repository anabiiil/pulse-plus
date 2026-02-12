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
