<template>
  <div class="add-to-cart-control flex flex-col items-center gap-3">
    <!-- Quantity stepper -->
    <div class="inline-flex items-center border border-gray-200 rounded-full overflow-hidden select-none bg-white">
      <button type="button" class="px-4 py-2 text-lg text-gray-600 hover:bg-gray-100 transition" @click.stop.prevent="quantity > 1 && quantity--">−</button>
      <span class="px-4 font-bold text-gray-800 min-w-[2.5rem] text-center">{{ quantity }}</span>
      <button type="button" class="px-4 py-2 text-lg text-gray-600 hover:bg-gray-100 transition" @click.stop.prevent="quantity++">+</button>
    </div>

    <!-- Add / Update button -->
    <button
      type="button"
      class="inline-flex items-center gap-2 font-semibold px-6 py-2.5 rounded-full shadow transition disabled:opacity-60 text-white"
      :class="cartItem ? 'bg-blue-500 hover:bg-blue-600' : 'bg-teal-500 hover:bg-teal-600'"
      :disabled="cartStore.loading"
      @click.stop.prevent="submit"
    >
      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
      </svg>
      {{ cartItem ? t.cart.updateCart : t.cart.addToCart }}
    </button>
  </div>
</template>

<script setup lang="ts">
import { computed, ref, watch } from 'vue';
import { useRouter } from 'vue-router';
import { useToast } from 'vue-toastification';
import { useAppStore } from '../../stores/website-index/appStore';
import { useCartStore } from '../../stores/website-index/cartStore';
import { useAuth } from '../../composables/useAuth';

const props = defineProps<{ product: any }>();

const appStore = useAppStore();
const cartStore = useCartStore();
const { isAuthenticated } = useAuth();
const router = useRouter();
const toast = useToast();

const t = computed(() => appStore.t);
const cartItem = computed(() => cartStore.items.find((i: any) => i.product_id === props.product.id));
const quantity = ref(1);

// Keep the local quantity in sync with the cart line (show its quantity when present)
watch(cartItem, (item) => {
  quantity.value = item ? item.quantity : 1;
}, { immediate: true });

async function submit() {
  if (!isAuthenticated.value) {
    toast.info(t.value.cart.loginRequired);
    router.push(`/${appStore.locale}/login`);
    return;
  }
  try {
    if (cartItem.value) {
      await cartStore.updateItem(cartItem.value.id, quantity.value);
      toast.success(t.value.cart.updated);
    } else {
      await cartStore.addItem(props.product.id, quantity.value);
      toast.success(t.value.cart.added);
    }
  } catch (e) {
    toast.error(t.value.productDetail.loadError);
  }
}
</script>
