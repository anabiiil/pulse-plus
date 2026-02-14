<template>
  <nav class="lg:hidden block w-full bg-white shadow-md px-6 py-4 flex items-center justify-between relative">
    <div>
      <router-link :to="homePath">
        <img :src="logoImg" class="w-[100px]" alt="Pulse Logo">
      </router-link>
    </div>
    <div class="flex items-center justify-center gap-4">
      <router-link
        v-if="isAuthenticated"
        :to="profilePath"
        class="w-9 h-9 rounded-full flex items-center justify-center bg-[#1BB2B1] cursor-pointer text-white shadow-xl"
        title="Profile"
      >
        <i class="pi pi-user"></i>
      </router-link>
      <router-link
        v-else
        :to="loginPath"
        class="w-9 h-9 rounded-full flex items-center justify-center bg-[#1BB2B1] cursor-pointer text-white shadow-xl"
        title="Login"
      >
        <i class="pi pi-sign-in"></i>
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
          :title="t.nav.language"
        >
          {{ t.nav.language }}
        </button>
      </div>
      <div>
        <ul class="p-2 flex flex-col gap-2 text-right">
          <li>
            <router-link
              :to="homePath"
              @click="appStore.closeMobileMenu"
              class="block py-2 px-3 rounded hover:bg-[#123057] hover:text-white transition-all"
            >
              {{ t.nav.home }}
            </router-link>
          </li>
          <li>
            <button
              @click="appStore.scrollToSection('products')"
              class="block py-2 px-3 rounded hover:bg-[#123057] hover:text-white transition-all w-full text-right"
            >
              {{ t.nav.store }}
            </button>
          </li>
          <li>
            <button
              @click="appStore.scrollToSection('features')"
              class="block py-2 px-3 rounded hover:bg-[#123057] hover:text-white transition-all w-full text-right"
            >
              {{ t.nav.services }}
            </button>
          </li>
          <li>
            <button
              @click="appStore.scrollToSection('about')"
              class="block py-2 px-3 rounded hover:bg-[#123057] hover:text-white transition-all w-full text-right"
            >
              {{ t.nav.about }}
            </button>
          </li>
          <li>
            <button
              @click="appStore.scrollToSection('contact')"
              class="block py-2 px-3 rounded hover:bg-[#123057] hover:text-white transition-all w-full text-right"
            >
              {{ t.nav.contact }}
            </button>
          </li>

          <!-- Authentication buttons -->
          <li v-if="!isAuthenticated" class="mt-2">
            <router-link
              :to="loginPath"
              @click="appStore.closeMobileMenu"
              class="block py-2 px-3 rounded bg-teal-500 text-white hover:bg-teal-600 transition-all font-semibold text-center"
            >
              {{ t.nav.login }}
            </router-link>
          </li>

          <template v-else>
            <li class="mt-2">
              <router-link
                :to="profilePath"
                @click="appStore.closeMobileMenu"
                class="block py-2 px-3 rounded bg-blue-500 text-white hover:bg-blue-600 transition-all font-semibold text-center"
              >
                {{ t.nav.profile }}
              </router-link>
            </li>
            <li>
              <button
                @click="handleLogout"
                :disabled="loggingOut"
                class="block py-2 px-3 rounded bg-red-500 text-white hover:bg-red-600 transition-all font-semibold text-center w-full disabled:opacity-50"
              >
                <span v-if="!loggingOut">{{ t.nav.logout }}</span>
                <span v-else>...</span>
              </button>
            </li>
          </template>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useAppStore } from '../../stores/website-index/appStore';
import { useAuth } from '../../composables/useAuth';
import { useToast } from 'vue-toastification';
import logoImg from '../../images/website/logo.png';

const router = useRouter();
const appStore = useAppStore();
const { isAuthenticated, logout } = useAuth();
const toast = useToast();
const loggingOut = ref(false);

// Use computed for reactive translations
const t = computed(() => appStore.t);

// Computed paths based on current locale
const currentLocale = computed(() => appStore.locale || 'ar');
const homePath = computed(() => currentLocale.value === 'en' ? '/en' : '/ar');
const loginPath = computed(() => currentLocale.value === 'en' ? '/en/login' : '/ar/login');
const profilePath = computed(() => currentLocale.value === 'en' ? '/en/profile' : '/ar/profile');

const handleLogout = async () => {
    // ...existing code...
};
    if (loggingOut.value) return;

    loggingOut.value = true;
    appStore.closeMobileMenu();

    try {
        await logout();
        toast.success(t.value.nav.logout === 'Logout' ? 'Logged out successfully' : 'تم تسجيل الخروج بنجاح');
    } catch (error) {
        console.error('Logout error:', error);
        toast.error(t.value.nav.logout === 'Logout' ? 'Logout failed' : 'فشل تسجيل الخروج');
    } finally {
        loggingOut.value = false;
    }
};

onMounted(() => {
    // Inject router into store for navigation
    appStore.setRouter(router);
});
</script>





