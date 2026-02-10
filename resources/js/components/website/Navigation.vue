<template>
    <!-- Top Contact Bar -->
    <div class="flex items-center text-white font-bold justify-center p-4 gap-10 w-full bg-[#03315A]">
        <p class="[direction:ltr]"><i class="pi pi-phone text-white mx-2 text-[18px]"></i> +2 01022335566</p>
        <p class="[direction:ltr]"><i class="pi pi-envelope text-white mx-2 text-[18px]"></i> info@pulse-plus.com</p>
    </div>

    <!-- Navigation Desktop -->
    <nav class="hidden lg:flex py-4 px-20 bg-white/90 shadow-md justify-between items-center">
        <div class="flex items-center gap-4">
            <router-link to="/" class="text-2xl font-bold text-gray-800">
                <img :src="logoImg" class="w-[120px]" alt="Pulse Logo">
            </router-link>
            <div>
                <router-link to="/" class="mx-4 transition duration-150 font-semibold" :class="$route.path === '/' ? 'text-teal-500 before:w-full before:h-0.5 before:bg-teal-500 before:absolute before:-bottom-2 before:left-0 relative' : 'hover:text-teal-500'">الرئيسية</router-link>
                <a href="/#products" class="relative transition duration-150 font-semibold mx-4 hover:text-teal-500">المتجر</a>
                <a href="/#features" class="hover:text-teal-500 transition duration-150 font-semibold mx-4">خدماتنا</a>
                <a href="/#features" class="hover:text-teal-500 transition duration-150 font-semibold mx-4">من نحن</a>
                <router-link to="/contact" class="hover:text-teal-500 transition duration-150 font-semibold mx-4">اتصل بنا</router-link>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <button class="flex items-center justify-center w-[50px] h-[50px] text-[18px] rounded-full shadow-xl">
                <i class="pi pi-moon"></i>
            </button>
            <button class="flex items-center justify-center w-[50px] h-[50px] text-[18px] rounded-full shadow-xl">
                EN
            </button>
            <router-link v-if="!isAuthenticated" to="/login" class="bg-teal-500 text-white px-5 py-2 rounded-[30px] shadow-lg font-semibold hover:bg-teal-600 transition duration-150">
                تسجيل الدخول
            </router-link>
            <router-link v-else to="/profile" class="bg-teal-500 text-white px-5 py-2 rounded-[30px] shadow-lg font-semibold hover:bg-teal-600 transition duration-150">
                الملف الشخصي
            </router-link>
        </div>
    </nav>

    <!-- Navigation Mobile -->
    <nav class="lg:hidden block w-full bg-white shadow-md px-6 py-4 flex items-center justify-between relative">
        <div>
            <router-link to="/">
                <img :src="logoImg" class="w-[100px]" alt="Pulse Logo">
            </router-link>
        </div>
        <div class="flex items-center justify-center gap-4">
            <router-link v-if="isAuthenticated" to="/profile" class="w-9 h-9 rounded-full flex items-center justify-center bg-[#1BB2B1] cursor-pointer text-white shadow-xl">
                <i class="pi pi-user"></i>
            </router-link>
            <button @click="toggleMenu" class="w-9 h-9 rounded-full flex items-center justify-center bg-[#FF6760] cursor-pointer text-white shadow-xl">
                <i class="pi pi-bars"></i>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div v-if="menuOpen" class="absolute flex-col z-50 p-6 bg-white/80 top-[100%] left-0 backdrop-blur-md shadow-lg">
            <div>
                <button class="bg-[#123057] rounded-4xl py-3 px-7 text-white cursor-pointer font-semibold">EN</button>
                <button class="bg-[#123057] rounded-4xl py-3 px-7 text-white cursor-pointer font-semibold"><i class="pi pi-moon"></i></button>
            </div>
            <div>
                <ul class="p-2 flex flex-col gap-2 text-right">
                    <li><router-link to="/" class="block py-2 px-3 rounded hover:bg-[#123057] hover:text-white transition-all">الرئيسية</router-link></li>
                    <li><a href="/#products" class="block py-2 px-3 rounded hover:bg-[#123057] hover:text-white transition-all">المتجر</a></li>
                    <li><a href="/#features" class="block py-2 px-3 rounded hover:bg-[#123057] hover:text-white transition-all">خدماتنا</a></li>
                    <li><a href="/#features" class="block py-2 px-3 rounded hover:bg-[#123057] hover:text-white transition-all">من نحن</a></li>
                    <li><router-link to="/contact" class="block py-2 px-3 rounded hover:bg-[#123057] hover:text-white transition-all">اتصل بنا</router-link></li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue';
import logoImg from '../../images/website/logo.png';

const menuOpen = ref(false);

const isAuthenticated = computed(() => {
    return (window as any).authUser !== null && (window as any).authUser !== undefined;
});

const toggleMenu = () => {
    menuOpen.value = !menuOpen.value;
};
</script>

