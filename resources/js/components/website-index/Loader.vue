<template>
  <div
    v-if="appStore.isLoading"
    class="fixed inset-0 z-50 flex items-center justify-center bg-[#123057] transition-opacity duration-700 ease-out"
    :class="{ 'opacity-0 pointer-events-none': !appStore.isLoading }"
  >
    <div class="relative w-24 h-24">
      <div class="absolute inset-0 rounded-full border-4 border-white/30"></div>
      <div class="absolute inset-0 rounded-full border-4 border-[#1BB2B1] border-t-transparent animate-spin"></div>
      <div class="absolute inset-6 rounded-full bg-white"></div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useAppStore } from '../../stores/website-index/appStore';

const appStore = useAppStore();
</script>

