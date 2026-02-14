<template>
  <section id="products" class="py-16">
    <div class="max-w-6xl mx-auto text-center mb-12">
      <h2 class="text-3xl font-bold text-gray-800">اختر الأمان الذي يناسبك</h2>
    </div>
    <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-8 px-4">
      <div
        v-for="(product, index) in displayProducts"
        :key="product.id || index"
        class="p-10"
      >
        <div class="bg-gray-50 flex items-center justify-center h-[320px] p-10 rounded-3xl shadow-xl transform transition duration-500 hover:scale-105 hover:shadow-2xl cursor-pointer relative overflow-hidden">
          <img :src="product.image_url || product.image" class="w-[240px]" :alt="product.name">
        </div>
        <div class="p-2 text-center">
          <h3 class="text-xl font-bold mt-4">
            {{ product.name }}
          </h3>
          <p v-if="product.description" class="text-gray-600 mt-2 text-sm" v-html="product.description"></p>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import { useDataStore } from '../../../stores/website-index/dataStore';
import product1 from '../../../images/website/product-1.png';
import product2 from '../../../images/website/product-2.png';

interface Product {
  id?: number;
  name: string;
  description?: string;
  image?: string;
  image_url?: string;
}

const dataStore = useDataStore();

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

// Use products from store, or fallback to static products
const displayProducts = computed(() => {
  return dataStore.products.length > 0 ? dataStore.products : fallbackProducts;
});
</script>






