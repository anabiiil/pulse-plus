<template>
  <nav class="hidden lg:flex py-4 px-20 bg-white/90 shadow-md justify-between items-center">
    <div class="flex items-center gap-4">
      <router-link to="/" class="text-2xl font-bold text-gray-800">
        <img :src="logoImg" class="w-[120px]" alt="Pulse Logo">
      </router-link>
      <div>
        <router-link
          to="/"
          class="mx-4 text-teal-500 transition duration-150 font-semibold before:w-full before:h-0.5 before:bg-teal-500 before:absolute before:-bottom-2 before:left-0 relative"
        >
          الرئيسية
        </router-link>
        <a href="#products" class="relative transition duration-150 font-semibold mx-4 hover:text-teal-500">المتجر</a>
        <a href="#features" class="hover:text-teal-500 transition duration-150 font-semibold mx-4">خدماتنا</a>
        <a href="#about" class="hover:text-teal-500 transition duration-150 font-semibold mx-4">من نحن</a>
        <a href="#contact" class="hover:text-teal-500 transition duration-150 font-semibold mx-4">اتصل بنا</a>
      </div>
    </div>
    <div class="flex items-center gap-4">
      <button
        @click="appStore.toggleDarkMode"
        class="flex items-center justify-center w-[50px] h-[50px] text-[18px] rounded-full shadow-xl"
      >
        <i class="pi pi-moon"></i>
      </button>
      <button
        @click="appStore.toggleLocale"
        class="flex items-center justify-center w-[50px] h-[50px] text-[18px] rounded-full shadow-xl"
      >
        {{ appStore.locale === 'ar' ? 'EN' : 'AR' }}
      </button>
      <router-link
        to="/login"
        class="bg-teal-500 text-white px-5 py-2 rounded-[30px] shadow-lg font-semibold hover:bg-teal-600 transition duration-150"
      >
        تسجيل الدخول
      </router-link>
    </div>
  </nav>
</template>

<script setup lang="ts">
import { useAppStore } from '../../stores/website-index/appStore';
import logoImg from '../../images/website/logo.png';

const appStore = useAppStore();
</script>




