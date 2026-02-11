import './bootstrap';
import '../css/website.css';
import 'vuetify/styles';
import 'primeicons/primeicons.css';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

import { createApp } from 'vue';
import { createVuetify } from 'vuetify';
import { createHead } from '@vueuse/head';
import { createPinia } from 'pinia';
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";

// Vuetify components and directives
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';

// Create Vuetify instance
const vuetify = createVuetify({
    components,
    directives,
});

// Import root component for website index
import WebsiteIndexApp from './components/website-index/App.vue';

// Import router for website index
import router from './website-index/router';

// Create head manager
const head = createHead();

// Create Pinia store
const pinia = createPinia();

// Create the Vue app
const app = createApp(WebsiteIndexApp);

// Mount the app to a DOM element
const websiteIndexApp = document.getElementById('website-index-app');
if (websiteIndexApp) {
    app.use(pinia);
    app.use(vuetify);
    app.use(router);
    app.use(head);
    app.use(Toast, {
        position: "top-right",
        timeout: 3000,
        closeOnClick: true,
        pauseOnFocusLoss: true,
        pauseOnHover: true,
        draggable: true,
        draggablePercent: 0.6,
        showCloseButtonOnHover: false,
        hideProgressBar: false,
        closeButton: "button",
        icon: true,
        rtl: false
    });
    app.mount('#website-index-app');
}

// Configure head meta tags
head.addHeadObjs({
    titleTemplate: '%s - Pulse',
    meta: [
        { name: 'description', content: 'Pulse - NFC Digital Solutions' },
        { name: 'viewport', content: 'width=device-width, initial-scale=1.0' },
    ],
});

