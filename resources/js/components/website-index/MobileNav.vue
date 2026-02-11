<template>
  <nav class="lg:hidden block w-full bg-white shadow-md px-6 py-4 flex items-center justify-between relative">
    <div>
      <router-link to="/">
        <img :src="logoImg" class="w-[100px]" alt="Pulse Logo">
      </router-link>
    </div>
    <div class="flex items-center justify-center gap-4">
      <router-link
        to="/profile"
        class="w-9 h-9 rounded-full flex items-center justify-center bg-[#1BB2B1] cursor-pointer text-white shadow-xl"
      >
        <i class="pi pi-user"></i>
      </router-link>
      <button
        @click="appStore.toggleMobileMenu"
        class="w-9 h-9 rounded-full flex items-center justify-center bg-[#FF6760] cursor-pointer text-white shadow-xl"
      >
        <i class="pi pi-bars"></i>
      </button>
    </div>

    <!-- Burger Menu -->
    <div
      v-show="appStore.isMobileMenuOpen"
      class="absolute flex-col z-50 p-6 bg-white/80 top-[100%] left-0 backdrop-blur-md shadow-lg"
    >
      <div class="flex gap-2">
        <button
          @click="appStore.toggleLocale"
          class="bg-[#123057] rounded-4xl py-3 px-7 text-white cursor-pointer font-semibold"
          :title="appStore.t.nav.language"
        >
          {{ appStore.t.nav.language }}
        </button>
        <button
          @click="appStore.toggleDarkMode"
          class="bg-[#123057] rounded-4xl py-3 px-7 text-white cursor-pointer font-semibold"
          :title="appStore.t.nav.darkMode"
        >
          <i class="pi pi-moon"></i>
        </button>
      </div>
      <div>
        <ul class="p-2 flex flex-col gap-2 text-right">
          <li>
            <router-link
              to="/"
              @click="appStore.closeMobileMenu"
              class="block py-2 px-3 rounded hover:bg-[#123057] hover:text-white transition-all"
            >
              {{ appStore.t.nav.home }}
            </router-link>
          </li>
          <li>
            <a
              href="#products"
              @click="appStore.closeMobileMenu"
              class="block py-2 px-3 rounded hover:bg-[#123057] hover:text-white transition-all"
            >
              {{ appStore.t.nav.store }}
            </a>
          </li>
          <li>
            <a
              href="#features"
              @click="appStore.closeMobileMenu"
              class="block py-2 px-3 rounded hover:bg-[#123057] hover:text-white transition-all"
            >
              {{ appStore.t.nav.services }}
            </a>
          </li>
          <li>
            <a
              href="#about"
              @click="appStore.closeMobileMenu"
              class="block py-2 px-3 rounded hover:bg-[#123057] hover:text-white transition-all"
            >
              {{ appStore.t.nav.about }}
            </a>
          </li>
          <li>
            <a
              href="#contact"
              @click="appStore.closeMobileMenu"
              class="block py-2 px-3 rounded hover:bg-[#123057] hover:text-white transition-all"
            >
              {{ appStore.t.nav.contact }}
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script setup lang="ts">
import { useAppStore } from '../../stores/website-index/appStore';
import logoImg from '../../images/website/logo.png';

const appStore = useAppStore();
</script>





