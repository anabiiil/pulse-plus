<template>
  <div class="index-page">
    <!-- Navigation (unified with auth support) -->
    <Navigation />

    <!-- Loading State -->
    <div v-if="dataStore.isDataLoading" class="flex items-center justify-center min-h-[50vh]">
      <div class="animate-spin rounded-full h-16 w-16 border-b-2 border-teal-500"></div>
    </div>

    <!-- Content -->
    <div v-else>
      <!-- Hero Slider Section -->
      <HeroSlider />

      <!-- Features Section -->
      <FeaturesSection />

      <!-- Products Section -->
      <ProductsSection />
    </div>

    <!-- Footer -->
    <Footer />
  </div>
</template>

<script setup lang="ts">
import { onMounted } from 'vue';
import { useHead } from '@vueuse/head';
import { useDataStore } from '../../../stores/website-index/dataStore';
import Navigation from '../../website/Navigation.vue';
import HeroSlider from '../sections/HeroSlider.vue';
import FeaturesSection from '../sections/FeaturesSection.vue';
import ProductsSection from '../sections/ProductsSection.vue';
import Footer from '../Footer.vue';

const dataStore = useDataStore();

useHead({
  title: 'Home',
});

onMounted(async () => {
  // Initialize home data (fetches sliders, products, services, and settings)
  await dataStore.initData();
});
</script>

<style scoped>
.index-page {
  min-height: 100vh;
  background: #fff;
}
</style>

