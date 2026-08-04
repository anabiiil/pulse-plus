<template>
  <div class="orders-page" :dir="appStore.isRTL ? 'rtl' : 'ltr'">
    <Navigation />

    <!-- Title header -->
    <section class="relative bg-gradient-to-b from-teal-50 via-gray-50 to-white border-b border-gray-100 overflow-hidden">
      <div class="absolute -top-16 -end-16 w-56 h-56 bg-teal-100/50 rounded-full blur-3xl"></div>
      <div class="relative max-w-7xl mx-auto px-4 py-12 md:py-14 text-center">
        <h1 class="text-3xl md:text-5xl font-extrabold text-gray-800 tracking-tight">{{ t.orders.title }}</h1>
        <div class="w-24 h-1.5 bg-teal-500 rounded-full mx-auto mt-5"></div>
      </div>
    </section>

    <section class="py-12 min-h-[45vh]">
      <div class="max-w-5xl mx-auto px-4">
        <OrdersList />
      </div>
    </section>

    <Footer />
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import { useHead } from '@vueuse/head';
import { useAppStore } from '../../../stores/website-index/appStore';
import Navigation from '../../website/Navigation.vue';
import Footer from '../Footer.vue';
import OrdersList from '../OrdersList.vue';

const appStore = useAppStore();
const t = computed(() => appStore.t);

useHead({ title: computed(() => t.value.orders.title) });
</script>

<style scoped>
.orders-page {
  min-height: 100vh;
  background: #fff;
}
</style>
