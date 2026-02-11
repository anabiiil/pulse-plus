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
          {{ appStore.t.nav.home }}
        </router-link>
        <a href="#products" class="relative transition duration-150 font-semibold mx-4 hover:text-teal-500">
          {{ appStore.t.nav.store }}
        </a>
        <a href="#features" class="hover:text-teal-500 transition duration-150 font-semibold mx-4">
          {{ appStore.t.nav.services }}
        </a>
        <a href="#about" class="hover:text-teal-500 transition duration-150 font-semibold mx-4">
          {{ appStore.t.nav.about }}
        </a>
        <a href="#contact" class="hover:text-teal-500 transition duration-150 font-semibold mx-4">
          {{ appStore.t.nav.contact }}
        </a>
      </div>
    </div>
    <div class="flex items-center gap-4">
      <button
        @click="appStore.toggleDarkMode"
        class="flex items-center justify-center w-[50px] h-[50px] text-[18px] rounded-full shadow-xl"
        :title="appStore.t.nav.darkMode"
      >
        <i class="pi pi-moon"></i>
      </button>
      <button
        @click="appStore.toggleLocale"
        class="flex items-center justify-center w-[50px] h-[50px] text-[18px] rounded-full shadow-xl font-semibold"
        :title="appStore.t.nav.language"
      >
        {{ appStore.t.nav.language }}
      </button>
      <router-link
        to="/login"
        class="bg-teal-500 text-white px-5 py-2 rounded-[30px] shadow-lg font-semibold hover:bg-teal-600 transition duration-150"
      >
        {{ appStore.t.nav.login }}
      </router-link>
    </div>
  </nav>
</template>

<script setup lang="ts">
import { onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useAppStore } from '../../stores/website-index/appStore';
import logoImg from '../../images/website/logo.png';

const router = useRouter();
const appStore = useAppStore();

onMounted(() => {
    // Inject router into store for navigation
    appStore.setRouter(router);
});
</script>




