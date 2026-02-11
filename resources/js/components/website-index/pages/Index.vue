<template>
  <div class="index-page">
    <!-- Top Bar -->
    <TopBar />

    <!-- Navigation -->
    <DesktopNav />
    <MobileNav />

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
import TopBar from '../TopBar.vue';
import DesktopNav from '../DesktopNav.vue';
import MobileNav from '../MobileNav.vue';
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

