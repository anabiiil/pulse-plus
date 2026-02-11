<template>
  <div id="app" class="min-h-screen transition-all duration-300">
    <!-- Loader -->
    <Loader />

    <!-- Router View -->
    <router-view v-slot="{ Component }">
      <transition name="fade" mode="out-in">
        <component :is="Component" :key="appStore.locale" />
      </transition>
    </router-view>
  </div>
</template>

<script setup lang="ts">
import { onMounted, watch } from 'vue';
import { useAppStore } from '../../stores/website-index/appStore';
import { useDataStore } from '../../stores/website-index/dataStore';
import Loader from './Loader.vue';

const appStore = useAppStore();
const dataStore = useDataStore();

onMounted(() => {
  // Initialize app
  appStore.init();
  dataStore.initData();
});

// Watch for locale changes
watch(() => appStore.locale, () => {
  // You can add any additional logic when locale changes
  console.log('Locale changed to:', appStore.locale);
});
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>

<style>
/* Global RTL/LTR styles */
html[dir="rtl"] {
  direction: rtl;
  text-align: right;
}

html[dir="ltr"] {
  direction: ltr;
  text-align: left;
}

/* Ensure body follows HTML direction */
html[dir="rtl"] body {
  direction: rtl;
  text-align: right;
}

html[dir="ltr"] body {
  direction: ltr;
  text-align: left;
}

/* Smooth transition for direction changes */
* {
  transition: direction 0.3s ease;
}
</style>

