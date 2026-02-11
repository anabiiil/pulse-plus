<template>
  <section id="products" class="py-16">
    <div class="max-w-6xl mx-auto text-center mb-12">
      <h2 class="text-3xl font-bold text-gray-800">اختر الأمان الذي يناسبك</h2>
    </div>
    <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-8 px-4">
      <div
        v-for="(product, index) in products"
        :key="index"
        class="p-10"
      >
        <div class="bg-gray-50 flex items-center justify-center h-[320px] p-10 rounded-3xl shadow-xl transform transition duration-500 hover:scale-105 hover:shadow-2xl cursor-pointer relative overflow-hidden">
          <img :src="product.image" class="w-[240px]" :alt="product.name">
        </div>
        <div class="p-2 text-center">
          <h3 class="text-xl font-bold mt-4">
            {{ product.name }}
          </h3>
          <button class="flex items-center text-teal-500 font-semibold mt-4">
            اطلب الان <i class="pi pi-arrow-circle-left mt-2 mr-2"></i>
          </button>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useDataStore } from '../../../stores/website-index/dataStore';
import product1 from '../../../images/website/product-1.png';
import product2 from '../../../images/website/product-2.png';

const dataStore = useDataStore();

const products = ref([
  {
    name: 'السوار الطبي',
    image: product2
  },
  {
    name: 'السلسلة الذكية',
    image: product1
  }
]);

// You can replace this with data from the store when API is ready
// const products = computed(() => dataStore.products);
</script>






