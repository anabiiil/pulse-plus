<template>
  <div id="app" class="min-h-screen transition-all duration-300" :class="{ 'rtl': appStore.isRTL }">
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

.rtl {
  direction: rtl;
}
</style>

