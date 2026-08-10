<template>
  <section id="products" class="py-16">
    <div class="max-w-6xl mx-auto text-center mb-12">
      <h2 class="text-3xl font-bold text-gray-800">{{ t.products.title }}</h2>
    </div>
    <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-8 px-4">
      <component
        :is="product.id ? 'router-link' : 'div'"
        v-for="(product, index) in displayProducts"
        :key="product.id || index"
        :to="product.id ? `/${appStore.locale}/products/${product.id}` : undefined"
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
          <div v-if="product.id" class="mt-4 flex justify-center">
            <AddToCartControl :product="product" />
          </div>
        </div>
      </component>
    </div>

    <!-- Go to store -->
    <div class="text-center mt-12">
      <router-link
        :to="`/${appStore.locale}/products`"
        class="inline-flex items-center gap-2 bg-teal-500 text-white font-semibold px-10 py-3 rounded-full shadow-lg hover:bg-teal-600 transition"
      >
        {{ t.products.viewAll }}
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" :class="{ 'rotate-180': appStore.isRTL }" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
        </svg>
      </router-link>
    </div>
  </section>
</template>

<script setup lang="ts">
import { computed, onMounted } from 'vue';
import { useDataStore } from '../../../stores/website-index/dataStore';
import { useAppStore } from '../../../stores/website-index/appStore';
import { useCartStore } from '../../../stores/website-index/cartStore';
import AddToCartControl from '../AddToCartControl.vue';
import product1 from '../../../images/website/product-1.png';
import product2 from '../../../images/website/product-2.png';

interface Product {
  id?: number;
  name: string;
  description?: string;
  price?: number | null;
  image?: string;
  image_url?: string | null;
}

const dataStore = useDataStore();
const appStore = useAppStore();
const cartStore = useCartStore();

// Get translations
const t = computed(() => appStore.t);

// Fallback products if no data from API
const fallbackProducts: Product[] = [
  {
    name: 'السوار الطبي',
    image: product2
  },
  {
    name: 'السلسلة الذكية',
    image: product1
  }
];

// Use products from store, or fallback to static products — show at most 4 on the home page
const displayProducts = computed(() => {
  const list = dataStore.products.length > 0 ? dataStore.products : fallbackProducts;
  return list.slice(0, 4);
});

onMounted(() => {
  if (!cartStore.loaded) {
    cartStore.fetchCart();
  }
});
</script>






