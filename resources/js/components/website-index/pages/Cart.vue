<template>
  <div class="cart-page" :dir="appStore.isRTL ? 'rtl' : 'ltr'">
    <Navigation />

    <!-- Title header -->
    <section class="relative bg-gradient-to-b from-teal-50 via-gray-50 to-white border-b border-gray-100 overflow-hidden">
      <div class="absolute -top-16 -end-16 w-56 h-56 bg-teal-100/50 rounded-full blur-3xl"></div>
      <div class="relative max-w-7xl mx-auto px-4 py-12 md:py-14 text-center">
        <h1 class="text-3xl md:text-5xl font-extrabold text-gray-800 tracking-tight">{{ t.cart.title }}</h1>
        <div class="w-24 h-1.5 bg-teal-500 rounded-full mx-auto mt-5"></div>
      </div>
    </section>

    <section class="py-12 min-h-[45vh]">
      <div class="max-w-6xl mx-auto px-4">
        <!-- Loading -->
        <div v-if="cartStore.loading && !cartStore.loaded" class="flex items-center justify-center py-20">
          <div class="animate-spin rounded-full h-14 w-14 border-b-2 border-teal-500"></div>
        </div>

        <!-- Empty -->
        <div v-else-if="cartStore.isEmpty" class="text-center py-16">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 mx-auto text-gray-200 mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
          </svg>
          <p class="text-xl text-gray-500 mb-6">{{ t.cart.empty }}</p>
          <router-link :to="`/${appStore.locale}/products`" class="inline-block bg-teal-500 text-white font-semibold px-8 py-3 rounded-full shadow-lg hover:bg-teal-600 transition">
            {{ t.cart.continueShopping }}
          </router-link>
        </div>

        <!-- Content -->
        <div v-else class="grid lg:grid-cols-3 gap-8">
          <!-- Items -->
          <div class="lg:col-span-2 space-y-4">
            <div
              v-for="item in cartStore.items"
              :key="item.id"
              class="flex items-center gap-4 bg-white rounded-2xl shadow-sm border border-gray-100 p-4"
            >
              <div class="w-20 h-20 rounded-xl bg-gray-50 flex items-center justify-center overflow-hidden flex-shrink-0">
                <img v-if="item.image_url" :src="item.image_url" :alt="item.name" class="max-h-full max-w-full object-contain">
              </div>
              <div class="min-w-0 flex-1">
                <p class="font-bold text-gray-800 truncate">{{ item.name }}</p>
                <p class="text-teal-600 font-semibold mt-1">{{ item.price }} {{ t.cart.currency }}</p>
              </div>
              <!-- qty stepper -->
              <div class="inline-flex items-center border border-gray-200 rounded-full overflow-hidden select-none">
                <button type="button" class="px-3 py-1.5 text-lg text-gray-600 hover:bg-gray-100 transition" :disabled="cartStore.loading" @click="changeQty(item, item.quantity - 1)">−</button>
                <span class="px-4 font-bold text-gray-800 min-w-[2rem] text-center">{{ item.quantity }}</span>
                <button type="button" class="px-3 py-1.5 text-lg text-gray-600 hover:bg-gray-100 transition" :disabled="cartStore.loading" @click="changeQty(item, item.quantity + 1)">+</button>
              </div>
              <div class="text-end min-w-[90px]">
                <p class="font-bold text-gray-800">{{ item.line_total }} {{ t.cart.currency }}</p>
                <button type="button" class="text-red-400 hover:text-red-600 text-sm mt-1 transition" @click="cartStore.removeItem(item.id)">
                  {{ t.cart.remove }}
                </button>
              </div>
            </div>

            <div class="text-end">
              <button type="button" class="text-gray-400 hover:text-red-500 text-sm transition" @click="cartStore.clear()">
                {{ t.cart.clear }}
              </button>
            </div>
          </div>

          <!-- Summary -->
          <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:sticky lg:top-24">
              <div class="flex items-center justify-between text-gray-700 mb-4">
                <span>{{ t.cart.subtotal }}</span>
                <span class="font-bold">{{ cartStore.subtotal }} {{ t.cart.currency }}</span>
              </div>
              <router-link
                :to="`/${appStore.locale}/checkout`"
                class="block text-center bg-teal-500 text-white font-semibold py-3 rounded-xl shadow-lg hover:bg-teal-600 transition"
              >
                {{ t.cart.checkout }}
              </router-link>
              <router-link
                :to="`/${appStore.locale}/products`"
                class="block text-center text-teal-600 font-semibold py-3 mt-2 hover:text-teal-700 transition"
              >
                {{ t.cart.continueShopping }}
              </router-link>
            </div>
          </div>
        </div>
      </div>
    </section>

    <Footer />
  </div>
</template>

<script setup lang="ts">
import { computed, onMounted } from 'vue';
import { useHead } from '@vueuse/head';
import { useToast } from 'vue-toastification';
import { useAppStore } from '../../../stores/website-index/appStore';
import { useCartStore } from '../../../stores/website-index/cartStore';
import Navigation from '../../website/Navigation.vue';
import Footer from '../Footer.vue';

const appStore = useAppStore();
const cartStore = useCartStore();
const toast = useToast();

const t = computed(() => appStore.t);

useHead({ title: computed(() => t.value.cart.title) });

async function changeQty(item: any, newQty: number) {
  if (newQty < 1) {
    await cartStore.removeItem(item.id);
    return;
  }
  try {
    await cartStore.updateItem(item.id, newQty);
  } catch (error) {
    toast.error(t.value.productDetail.loadError);
  }
}

onMounted(() => {
  cartStore.fetchCart();
});
</script>

<style scoped>
.cart-page {
  min-height: 100vh;
  background: #fff;
}
</style>
