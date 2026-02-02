import './bootstrap';
import 'vuetify/styles';
import { createApp } from 'vue';
import { createVuetify } from 'vuetify';
import { createHead } from '@vueuse/head';
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
import './main/alerts.ts';

// Vuetify components and directives
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';

const vuetify = createVuetify({
    components,
    directives,
});

// Import website components
import WebsiteLayout from './components/website/Layout.vue';

// Import website router
import websiteRouter from './website/router.ts';

// Create the Vue app
const app = createApp(WebsiteLayout);
const head = createHead();
import { createPinia } from 'pinia';

const pinia = createPinia();

// Mount the app to a DOM element
let websiteApp = document.getElementById('website-app');
if (websiteApp) {
    app.use(pinia);
    app.use(vuetify);
    app.use(websiteRouter);
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
    app.mount('#website-app');
}

head.addHeadObjs({
    titleTemplate: '%s - Pulse',
    meta: [
        { name: 'description', content: 'Pulse Website.' },
        { name: 'viewport', content: 'width=device-width, initial-scale=1.0' },
    ],
});
