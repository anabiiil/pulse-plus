import {createApp} from 'vue';
import Sidebar from '../components/dashboard/sidebar.vue';
import sidebarRouter from './router.ts';

const sidebarApp = createApp(Sidebar);
sidebarApp.use(sidebarRouter);
sidebarApp.mount('#sidebar');
