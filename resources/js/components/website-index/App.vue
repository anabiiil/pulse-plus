<template>
  <div id="app" class="min-h-screen">
    <!-- Loader -->
    <Loader />

    <!-- Router View -->
    <router-view v-slot="{ Component }">
      <transition name="fade" mode="out-in">
        <component :is="Component" />
      </transition>
    </router-view>
  </div>
</template>

<script setup lang="ts">
import { onMounted } from 'vue';
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
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>

