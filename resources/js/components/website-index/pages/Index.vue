<template>
  <div class="index-page">
    <!-- Navigation (unified with auth support) -->
    <Navigation />

    <!-- Hero Slider Section -->
    <HeroSlider />

    <!-- Features Section -->
    <FeaturesSection />

    <!-- Products Section -->
    <ProductsSection />

    <!-- Footer -->
    <Footer />
  </div>
</template>

<script setup lang="ts">
import { onMounted } from 'vue';
import { useHead } from '@vueuse/head';
import Navigation from '../../website/Navigation.vue';
import HeroSlider from '../sections/HeroSlider.vue';
import FeaturesSection from '../sections/FeaturesSection.vue';
import ProductsSection from '../sections/ProductsSection.vue';
import Footer from '../Footer.vue';

useHead({
  title: 'Home',
});

onMounted(() => {
  // Any additional initialization for the index page
});
</script>

<style scoped>
.index-page {
  min-height: 100vh;
  background: #fff;
}
</style>

