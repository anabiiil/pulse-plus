import 'vuetify/styles';
import {createApp} from 'vue';
import {createVuetify} from 'vuetify';
import {formatDate} from "./main/date.ts";
import {createHead} from '@vueuse/head';
import {VDateInput} from "vuetify/labs/components";


// Vuetify components and directives (optional)
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';

const vuetify = createVuetify({
    components,
    directives,
    VDateInput
    // Add custom configurations here
});
//vue


// Import your components
import mainDashboard from './components/dashboard/AppMain.vue';
import AdminLoginForm from './components/dashboard/auth/LoginForm.vue';

import router from './main/router.ts'; // Import router

// Create the Vue app
const app = createApp({});
const head = createHead();
import {createPinia} from 'pinia';


const pinia = createPinia();


// Register components
app.component('admin-login-form', AdminLoginForm);

// Mount the app to a DOM element
let appMain = document.getElementById('app')
if (appMain) {
    app.use(pinia);
    app.use(vuetify);
    app.use(router);
    app.use(head);
    app.config.globalProperties.$formatDate = formatDate;
    app.mount('#app');
}

head.addHeadObjs({
    titleTemplate: '%s - Pulse Dashboard',
    meta: [
        {name: 'description', content: 'Pulse .'},
        {name: 'viewport', content: 'width=device-width, initial-scale=1.0'},
    ],
});





