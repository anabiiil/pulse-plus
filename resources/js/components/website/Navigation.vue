<template>
    <!-- Top Contact Bar -->
    <div class="flex items-center text-white font-bold justify-center p-4 gap-10 w-full bg-[#03315A]">
        <p class="[direction:ltr]"><i class="pi pi-phone text-white mx-2 text-[18px]"></i> +2 01022335566</p>
        <p class="[direction:ltr]"><i class="pi pi-envelope text-white mx-2 text-[18px]"></i> info@pulse-plus.com</p>
    </div>

    <!-- Navigation Desktop -->
    <nav class="hidden lg:flex py-4 px-20 bg-white/90 shadow-md justify-between items-center">
        <div class="flex items-center gap-4">
            <router-link :to="homePath" class="text-2xl font-bold text-gray-800">
                <img :src="logoImg" class="w-[120px]" alt="Pulse Logo">
            </router-link>
            <div>
                <router-link :to="homePath" class="mx-4 transition duration-150 font-semibold" :class="$route.path === '/ar' || $route.path === '/en' ? 'text-teal-500 before:w-full before:h-0.5 before:bg-teal-500 before:absolute before:-bottom-2 before:left-0 relative' : 'hover:text-teal-500'">{{ t.nav.home }}</router-link>
                <button @click="scrollToSection('products')" class="relative transition duration-150 font-semibold mx-4 hover:text-teal-500 cursor-pointer">{{ t.nav.store }}</button>
                <button @click="scrollToSection('features')" class="hover:text-teal-500 transition duration-150 font-semibold mx-4 cursor-pointer">{{ t.nav.services }}</button>
                <button @click="scrollToSection('about')" class="hover:text-teal-500 transition duration-150 font-semibold mx-4 cursor-pointer">{{ t.nav.about }}</button>
                <button @click="scrollToSection('contact')" class="hover:text-teal-500 transition duration-150 font-semibold mx-4 cursor-pointer">{{ t.nav.contact }}</button>
            </div>
        </div>
        <div class="flex items-center gap-4">
<!--            <button @click="toggleDarkMode" class="flex items-center justify-center w-[50px] h-[50px] text-[18px] rounded-full shadow-xl">-->
<!--                <i class="pi pi-moon"></i>-->
<!--            </button>-->
            <button @click="toggleLanguage" class="flex items-center justify-center w-[50px] h-[50px] text-[18px] rounded-full shadow-xl font-semibold">
                {{ t.nav.language }}
            </button>
            <!-- Login button when not authenticated -->
            <router-link v-if="!isAuthenticated" :to="loginPath" class="bg-teal-500 text-white px-5 py-2 rounded-[30px] shadow-lg font-semibold hover:bg-teal-600 transition duration-150">
                {{ t.nav.login }}
            </router-link>
            <!-- Profile and Logout buttons when authenticated -->
            <template v-else>
                <router-link :to="profilePath" class="bg-blue-500 text-white px-5 py-2 rounded-[30px] shadow-lg font-semibold hover:bg-blue-600 transition duration-150">
                    {{ t.nav.profile }}
                </router-link>
                <button @click="handleLogout" :disabled="loggingOut" class="bg-red-500 text-white px-5 py-2 rounded-[30px] shadow-lg font-semibold hover:bg-red-600 transition duration-150 disabled:opacity-50">
                    <span v-if="!loggingOut">{{ t.nav.logout }}</span>
                    <span v-else>...</span>
                </button>
            </template>
        </div>
    </nav>

    <!-- Navigation Mobile -->
    <nav class="lg:hidden block w-full bg-white shadow-md px-6 py-4 flex items-center justify-between relative">
        <div>
            <router-link :to="homePath">
                <img :src="logoImg" class="w-[100px]" alt="Pulse Logo">
            </router-link>
        </div>
        <div class="flex items-center justify-center gap-4">
            <router-link v-if="isAuthenticated" :to="profilePath" class="w-9 h-9 rounded-full flex items-center justify-center bg-[#1BB2B1] cursor-pointer text-white shadow-xl">
                <i class="pi pi-user"></i>
            </router-link>
            <button @click="toggleMenu" class="w-9 h-9 rounded-full flex items-center justify-center bg-[#FF6760] cursor-pointer text-white shadow-xl">
                <i class="pi pi-bars"></i>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div v-if="menuOpen" class="absolute flex-col z-50 p-6 bg-white/80 top-[100%] left-0 backdrop-blur-md shadow-lg">
            <div class="mb-4 flex gap-2">
                <button @click="toggleLanguage" class="bg-[#123057] rounded-4xl py-3 px-7 mx-auto text-white cursor-pointer font-semibold">{{ t.nav.language }}</button>
<!--                <button @click="toggleDarkMode" class="bg-[#123057] rounded-4xl py-3 px-7 text-white cursor-pointer font-semibold"><i class="pi pi-moon"></i></button>-->
            </div>
            <div>
                <ul class="p-2 flex flex-col gap-2 text-center" >
                    <li><router-link :to="homePath" @click="toggleMenu" class="block py-2 px-3 rounded hover:bg-[#123057] hover:text-white transition-all">{{ t.nav.home }}</router-link></li>
                    <li><button @click="scrollToSection('products')" class="block py-2 px-3 rounded hover:bg-[#123057] hover:text-white transition-all w-full cursor-pointer">{{ t.nav.store }}</button></li>
                    <li><button @click="scrollToSection('features')" class="block py-2 px-3 rounded hover:bg-[#123057] hover:text-white transition-all w-full cursor-pointer">{{ t.nav.services }}</button></li>
                    <li><button @click="scrollToSection('about')" class="block py-2 px-3 rounded hover:bg-[#123057] hover:text-white transition-all w-full cursor-pointer">{{ t.nav.about }}</button></li>
                    <li><button @click="scrollToSection('contact')" class="block py-2 px-3 rounded hover:bg-[#123057] hover:text-white transition-all w-full cursor-pointer">{{ t.nav.contact }}</button></li>
                    <!-- Logout button for mobile when authenticated -->
                    <li v-if="isAuthenticated">
                        <button @click="handleLogout" :disabled="loggingOut" class="block py-2 px-3 rounded bg-red-500 text-white hover:bg-red-600 transition-all font-semibold disabled:opacity-50 w-full">
                            <span v-if="!loggingOut">{{ t.nav.logout }}</span>
                            <span v-else>...</span>
                        </button>
                    </li>
                    <li v-else>
                        <router-link :to="loginPath" @click="toggleMenu" class="block py-2 px-3 rounded bg-teal-500 text-white hover:bg-teal-600 transition-all font-semibold text-center">{{ t.nav.login }}</router-link>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useWebsiteStore } from '../../stores/websiteStore';
import { useAuth } from '../../composables/useAuth';
import { useToast } from 'vue-toastification';
import logoImg from '../../images/website/logo.png';

const router = useRouter();
const websiteStore = useWebsiteStore();
const { isAuthenticated, logout } = useAuth();
const toast = useToast();

const menuOpen = ref(false);
const loggingOut = ref(false);

const t = computed(() => websiteStore.t);
const isRTL = computed(() => websiteStore.isRTL);

// Computed paths based on current locale
const currentLocale = computed(() => websiteStore.locale || 'ar');
const homePath = computed(() => currentLocale.value === 'en' ? '/en' : '/ar');
const loginPath = computed(() => currentLocale.value === 'en' ? '/en/login' : '/ar/login');
const profilePath = computed(() => currentLocale.value === 'en' ? '/en/profile' : '/ar/profile');

const toggleMenu = () => {
    menuOpen.value = !menuOpen.value;
};

const scrollToSection = (sectionId: string) => {
    menuOpen.value = false; // Close menu
    websiteStore.scrollToSection(sectionId);
};

const toggleLanguage = () => {
    websiteStore.toggleLocale();
};

const toggleDarkMode = () => {
    websiteStore.toggleDarkMode();
};

const handleLogout = async () => {
    if (loggingOut.value) return;

    loggingOut.value = true;
    menuOpen.value = false; // Close mobile menu

    try {
        await logout();
        toast.success('تم تسجيل الخروج بنجاح');
        // Logout function in useAuth already redirects to home
    } catch (error) {
        console.error('Logout error:', error);
        toast.error('فشل تسجيل الخروج');
    } finally {
        loggingOut.value = false;
    }
};

onMounted(() => {
    // Initialize store if not already initialized
    if (!websiteStore.isLoading) {
        websiteStore.init();
    }
    // Inject router into store for navigation
    websiteStore.setRouter(router);
});
</script>

