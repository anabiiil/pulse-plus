<template>
  <div class="relative">
    <!-- Cart icon button -->
    <button
      type="button"
      class="relative w-10 h-10 rounded-full flex items-center justify-center bg-gray-100 hover:bg-teal-50 text-gray-700 hover:text-teal-600 transition"
      :aria-label="t.cart.title"
      @click="onIconClick"
    >
      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
      </svg>
      <span
        v-if="cartStore.count > 0"
        class="absolute -top-1 -end-1 min-w-[20px] h-5 px-1 rounded-full bg-teal-500 text-white text-xs font-bold flex items-center justify-center"
      >
        {{ cartStore.count }}
      </span>
    </button>

    <!-- Dropdown -->
    <template v-if="open">
      <!-- click-outside catcher -->
      <div class="fixed inset-0 z-40" @click="open = false"></div>

      <div
        class="absolute z-50 mt-3 w-80 max-w-[90vw] bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden"
        :class="appStore.isRTL ? 'start-0' : 'end-0'"
        style="top: 100%"
      >
        <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
          <span class="font-bold text-gray-800">{{ t.cart.title }}</span>
          <span class="text-sm text-gray-500">{{ cartStore.count }} {{ t.cart.itemsCount }}</span>
        </div>

        <!-- Empty -->
        <div v-if="cartStore.isEmpty" class="px-4 py-8 text-center text-gray-500">
          {{ t.cart.empty }}
        </div>

        <!-- Items -->
        <div v-else class="max-h-72 overflow-y-auto divide-y divide-gray-50">
          <div v-for="item in cartStore.items" :key="item.id" class="flex items-center gap-3 p-3">
            <div class="w-12 h-12 rounded-lg bg-gray-50 flex items-center justify-center overflow-hidden flex-shrink-0">
              <img v-if="item.image_url" :src="item.image_url" :alt="item.name" class="max-h-full max-w-full object-contain">
            </div>
            <div class="min-w-0 flex-1">
              <p class="font-semibold text-gray-800 text-sm truncate">{{ item.name }}</p>
              <p class="text-xs text-gray-500">{{ item.quantity }} × {{ item.price }} {{ t.cart.currency }}</p>
            </div>
            <button type="button" class="text-gray-400 hover:text-red-500 transition" :aria-label="t.cart.remove" @click="remove(item.id)">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>

        <!-- Footer -->
        <div v-if="!cartStore.isEmpty" class="p-4 border-t border-gray-100">
          <div class="flex items-center justify-between mb-3">
            <span class="text-gray-600">{{ t.cart.subtotal }}</span>
            <span class="font-bold text-teal-600">{{ cartStore.subtotal }} {{ t.cart.currency }}</span>
          </div>
          <div class="flex gap-2">
            <router-link
              :to="`/${appStore.locale}/cart`"
              class="flex-1 text-center border border-teal-500 text-teal-600 font-semibold py-2 rounded-xl hover:bg-teal-50 transition"
              @click="open = false"
            >
              {{ t.cart.viewCart }}
            </router-link>
            <router-link
              :to="`/${appStore.locale}/checkout`"
              class="flex-1 text-center bg-teal-500 text-white font-semibold py-2 rounded-xl hover:bg-teal-600 transition"
              @click="open = false"
            >
              {{ t.cart.checkout }}
            </router-link>
          </div>
        </div>
      </div>
    </template>
  </div>
</template>

<script setup lang="ts">
import { computed, onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAppStore } from '../../stores/website-index/appStore';
import { useCartStore } from '../../stores/website-index/cartStore';
import { useAuth } from '../../composables/useAuth';

const appStore = useAppStore();
const cartStore = useCartStore();
const { isAuthenticated } = useAuth();
const router = useRouter();

const t = computed(() => appStore.t);
const open = ref(false);

function onIconClick() {
  if (!isAuthenticated.value) {
    router.push(`/${appStore.locale}/login`);
    return;
  }
  open.value = !open.value;
  if (open.value && !cartStore.loaded) {
    cartStore.fetchCart();
  }
}

async function remove(itemId: number) {
  await cartStore.removeItem(itemId);
}

onMounted(() => {
  if (isAuthenticated.value) {
    cartStore.fetchCart();
  }
});
</script>
