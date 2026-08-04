<template>
  <div class="products-page" :dir="appStore.isRTL ? 'rtl' : 'ltr'">
    <Navigation />

    <!-- Title header (same style as the product details page) -->
    <section class="relative bg-gradient-to-b from-teal-50 via-gray-50 to-white border-b border-gray-100 overflow-hidden">
      <div class="absolute -top-16 -end-16 w-56 h-56 bg-teal-100/50 rounded-full blur-3xl"></div>
      <div class="relative max-w-7xl mx-auto px-4 py-12 md:py-14 text-center">
        <h1 class="text-3xl md:text-5xl font-extrabold text-gray-800 tracking-tight">{{ t.products.allTitle }}</h1>
        <div class="w-24 h-1.5 bg-teal-500 rounded-full mx-auto mt-5"></div>
      </div>
    </section>

    <section class="py-16 min-h-[50vh]">
      <!-- Loading -->
      <div v-if="loading" class="flex items-center justify-center py-20">
        <div class="animate-spin rounded-full h-14 w-14 border-b-2 border-teal-500"></div>
      </div>

      <!-- Empty -->
      <div v-else-if="!products.length" class="text-center py-20 text-gray-500 text-lg">
        {{ t.products.empty }}
      </div>

      <!-- Grid: same look as the homepage products section (2 per row) -->
      <template v-else>
        <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-8 px-4">
          <router-link
            v-for="product in products"
            :key="product.id"
            :to="`/${appStore.locale}/products/${product.id}`"
            class="p-10 block"
          >
            <div class="bg-gray-50 flex items-center justify-center h-[320px] p-10 rounded-3xl shadow-xl transform transition duration-500 hover:scale-105 hover:shadow-2xl cursor-pointer relative overflow-hidden">
              <img :src="product.image_url || product.image" class="w-[240px]" :alt="product.name">
            </div>
            <div class="p-2 text-center">
              <h3 class="text-xl font-bold mt-4">
                {{ product.name }}
              </h3>
              <p v-if="product.price" class="text-teal-600 font-bold text-lg mt-2">
                {{ product.price }} {{ t.products.currency }}
              </p>
              <div class="mt-4 flex justify-center">
                <AddToCartControl :product="product" />
              </div>
            </div>
          </router-link>
        </div>

        <!-- Pagination -->
        <div v-if="lastPage > 1" class="flex items-center justify-center gap-2 mt-8">
          <button
            type="button"
            class="px-4 py-2 rounded-xl border border-gray-200 font-semibold text-gray-600 hover:bg-teal-50 hover:text-teal-600 disabled:opacity-40 disabled:cursor-not-allowed transition"
            :disabled="page <= 1"
            @click="goTo(page - 1)"
          >
            {{ t.products.prev }}
          </button>

          <button
            v-for="p in lastPage"
            :key="p"
            type="button"
            class="w-10 h-10 rounded-xl font-semibold transition inline-flex items-center justify-center leading-none"
            :class="p === page ? 'bg-teal-500 text-white shadow-lg' : 'border border-gray-200 text-gray-600 hover:bg-teal-50 hover:text-teal-600'"
            @click="goTo(p)"
          >
            {{ p }}
          </button>

          <button
            type="button"
            class="px-4 py-2 rounded-xl border border-gray-200 font-semibold text-gray-600 hover:bg-teal-50 hover:text-teal-600 disabled:opacity-40 disabled:cursor-not-allowed transition"
            :disabled="page >= lastPage"
            @click="goTo(page + 1)"
          >
            {{ t.products.next }}
          </button>
        </div>
      </template>
    </section>

    <Footer />
  </div>
</template>

<script setup lang="ts">
import { computed, onMounted, ref, watch } from 'vue';
import axios from 'axios';
import { useHead } from '@vueuse/head';
import { useAppStore } from '../../../stores/website-index/appStore';
import { useCartStore } from '../../../stores/website-index/cartStore';
import { useAuth } from '../../../composables/useAuth';
import Navigation from '../../website/Navigation.vue';
import Footer from '../Footer.vue';
import AddToCartControl from '../AddToCartControl.vue';

const appStore = useAppStore();
const cartStore = useCartStore();
const { isAuthenticated } = useAuth();
const t = computed(() => appStore.t);

const PER_PAGE = 4;
const products = ref<any[]>([]);
const loading = ref(true);
const page = ref(1);
const lastPage = ref(1);

useHead({
  title: computed(() => t.value.products.allTitle),
});

async function fetchProducts() {
  loading.value = true;
  try {
    const response = await axios.get('/api/website/products', {
      params: { per_page: PER_PAGE, page: page.value },
      headers: { 'Accept-Language': appStore.locale },
    });
    products.value = response.data.data || [];
    lastPage.value = response.data.pagination?.meta?.page?.last || 1;
  } catch (error) {
    console.error('Error fetching products:', error);
    products.value = [];
  } finally {
    loading.value = false;
  }
}

function goTo(p: number) {
  if (p < 1 || p > lastPage.value || p === page.value) return;
  page.value = p;
}

watch([page, () => appStore.locale], fetchProducts, { immediate: true });

onMounted(() => {
  if (isAuthenticated.value && !cartStore.loaded) {
    cartStore.fetchCart();
  }
});
</script>

<style scoped>
.products-page {
  min-height: 100vh;
  background: #fff;
}
</style>
