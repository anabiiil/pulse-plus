<template>
  <div class="product-detail-page" :dir="appStore.isRTL ? 'rtl' : 'ltr'">
    <Navigation />

    <!-- Loading State -->
    <div v-if="dataStore.isProductLoading" class="flex items-center justify-center min-h-[60vh]">
      <div class="animate-spin rounded-full h-16 w-16 border-b-2 border-teal-500"></div>
    </div>

    <!-- Not Found State -->
    <div v-else-if="!product" class="flex flex-col items-center justify-center min-h-[60vh] px-4 text-center">
      <p class="text-2xl font-bold text-gray-700 mb-6">{{ t.productDetail.notFound }}</p>
      <router-link :to="homePath" class="text-teal-600 font-bold hover:text-teal-500">
        {{ t.productDetail.back }}
      </router-link>
    </div>

    <template v-else>
      <!-- Title header -->
      <section class="relative bg-gradient-to-b from-teal-50 via-gray-50 to-white border-b border-gray-100 overflow-hidden">
        <div class="absolute -top-16 -end-16 w-56 h-56 bg-teal-100/50 rounded-full blur-3xl"></div>
        <div class="relative max-w-7xl mx-auto px-4 py-12 md:py-14 text-center">
          <!-- Breadcrumb -->
          <nav class="flex items-center justify-center gap-2 text-sm text-gray-500 mb-4">
            <router-link :to="homePath" class="hover:text-teal-600 transition">{{ t.productDetail.home }}</router-link>
            <span>/</span>
            <span class="text-gray-700 font-medium truncate max-w-[220px]">{{ product.name }}</span>
          </nav>
          <h1 class="text-3xl md:text-5xl font-extrabold text-gray-800 tracking-tight">{{ product.name }}</h1>
          <div class="w-24 h-1.5 bg-teal-500 rounded-full mx-auto mt-5"></div>
        </div>
      </section>

      <!-- Body: centered product + sidebar (sidebar sits on the logical end side:
           left in Arabic/RTL, right in English/LTR) -->
      <section class="py-12">
        <div
          class="max-w-7xl mx-auto px-4 grid gap-8"
          :class="hasOthers ? 'lg:grid-cols-12' : 'lg:grid-cols-1'"
        >
          <!-- Main product (centered) -->
          <main :class="hasOthers ? 'lg:col-span-8' : ''" class="mx-auto w-full max-w-3xl">
            <!-- Media card -->
            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
              <!-- Video (after play) -->
              <div v-if="showVideo && hasVideo" class="relative w-full aspect-video bg-black">
                <iframe
                  :src="videoSrc"
                  class="absolute inset-0 w-full h-full"
                  frameborder="0"
                  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                  allowfullscreen
                ></iframe>
              </div>

              <!-- Image with optional play overlay -->
              <div
                v-else
                class="relative flex items-center justify-center h-[360px] md:h-[460px] p-10 bg-gradient-to-br from-gray-50 to-white"
                :class="{ 'cursor-pointer group': hasVideo }"
                @click="hasVideo && playVideo()"
              >
                <img
                  v-if="imageSrc"
                  :src="imageSrc"
                  :alt="product.name"
                  class="max-h-full max-w-[300px] object-contain transition duration-500"
                  :class="{ 'group-hover:scale-105': hasVideo }"
                >
                <div v-else class="text-gray-300">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                </div>

                <!-- Play button -->
                <button
                  v-if="hasVideo"
                  type="button"
                  class="absolute inset-0 flex items-center justify-center"
                  :aria-label="t.productDetail.playVideo"
                  @click.stop="playVideo"
                >
                  <span class="flex items-center justify-center w-20 h-20 rounded-full bg-teal-500/90 text-white shadow-2xl ring-8 ring-white/40 transform transition duration-300 group-hover:scale-110 group-hover:bg-teal-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-9 h-9 ms-1" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M8 5v14l11-7z" />
                    </svg>
                  </span>
                </button>
              </div>
            </div>

            <!-- Price + add to cart -->
            <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
              <span v-if="product.price" class="inline-flex items-baseline gap-2 bg-teal-50 text-teal-700 rounded-2xl px-6 py-3 shadow-sm">
                <span class="text-4xl font-extrabold">{{ product.price }}</span>
                <span class="text-lg font-semibold">{{ t.products.currency }}</span>
              </span>

              <!-- Quantity stepper -->
              <div class="inline-flex items-center border border-gray-200 rounded-full overflow-hidden select-none">
                <button type="button" class="px-4 py-2 text-xl text-gray-600 hover:bg-gray-100 transition" @click="quantity > 1 && quantity--">−</button>
                <span class="px-5 font-bold text-gray-800 min-w-[2.5rem] text-center">{{ quantity }}</span>
                <button type="button" class="px-4 py-2 text-xl text-gray-600 hover:bg-gray-100 transition" @click="quantity++">+</button>
              </div>

              <!-- Add to cart -->
              <button
                type="button"
                class="inline-flex items-center gap-2 bg-teal-500 hover:bg-teal-600 text-white font-semibold px-8 py-3 rounded-full shadow-lg transition disabled:opacity-60"
                :disabled="cartStore.loading"
                @click="handleAddToCart"
              >
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                {{ cartItem ? t.cart.updateCart : t.cart.addToCart }}
              </button>
            </div>

            <!-- Details -->
            <div v-if="product.description" class="mt-8 bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-8 text-start">
              <div class="flex items-center gap-3 mb-5">
                <span class="w-2 h-6 bg-teal-500 rounded-full"></span>
                <h2 class="text-xl font-bold text-gray-800">{{ t.productDetail.description }}</h2>
              </div>
              <div class="product-description text-gray-600 leading-relaxed" v-html="product.description"></div>
            </div>
          </main>

          <!-- Sidebar: other products -->
          <aside v-if="hasOthers" class="lg:col-span-4">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-5 lg:sticky lg:top-24">
              <div class="flex items-center gap-3 mb-5">
                <span class="w-2 h-6 bg-teal-500 rounded-full"></span>
                <h3 class="text-lg font-bold text-gray-800">{{ t.productDetail.related }}</h3>
              </div>

              <ul class="space-y-3">
                <li v-for="item in otherProducts" :key="item.id">
                  <router-link
                    :to="`/${appStore.locale}/products/${item.id}`"
                    class="flex items-center gap-4 p-3 rounded-2xl border border-transparent hover:border-teal-100 hover:bg-teal-50/60 transition group"
                  >
                    <div class="flex-shrink-0 w-16 h-16 rounded-xl bg-gray-50 flex items-center justify-center overflow-hidden">
                      <img
                        v-if="item.image_url || item.image"
                        :src="item.image_url || item.image"
                        :alt="item.name"
                        class="max-h-full max-w-full object-contain"
                      >
                      <svg v-else xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                      </svg>
                    </div>
                    <div class="min-w-0 flex-1 text-start">
                      <p class="font-semibold text-gray-800 truncate group-hover:text-teal-700">{{ item.name }}</p>
                      <p v-if="item.price" class="text-teal-600 font-bold text-sm mt-1">
                        {{ item.price }} {{ t.products.currency }}
                      </p>
                    </div>
                  </router-link>
                </li>
              </ul>
            </div>
          </aside>
        </div>
      </section>
    </template>

    <Footer />
  </div>
</template>

<script setup lang="ts">
import { computed, ref, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useHead } from '@vueuse/head';
import { useToast } from 'vue-toastification';
import { useDataStore } from '../../../stores/website-index/dataStore';
import { useAppStore } from '../../../stores/website-index/appStore';
import { useCartStore } from '../../../stores/website-index/cartStore';
import { useAuth } from '../../../composables/useAuth';
import Navigation from '../../website/Navigation.vue';
import Footer from '../Footer.vue';

const route = useRoute();
const router = useRouter();
const dataStore = useDataStore();
const appStore = useAppStore();
const cartStore = useCartStore();
const { isAuthenticated } = useAuth();
const toast = useToast();

const t = computed(() => appStore.t);
const product = computed(() => dataStore.product);
const showVideo = ref(false);
const quantity = ref(1);

// The matching cart line for this product (if it's already in the cart)
const cartItem = computed(() =>
  product.value ? cartStore.items.find((i: any) => i.product_id === product.value.id) : undefined
);

/**
 * Keep the quantity stepper in sync with the cart:
 * show the existing quantity if the product is already in the cart.
 */
watch(
  [() => product.value?.id, cartItem],
  () => {
    quantity.value = cartItem.value ? cartItem.value.quantity : 1;
  },
  { immediate: true }
);

/**
 * Add the product to the cart, or update its quantity if it's already there
 * (never silently increments an existing line). Requires login.
 */
async function handleAddToCart() {
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
      await cartStore.addItem(product.value.id, quantity.value);
      toast.success(t.value.cart.added);
    }
  } catch (error) {
    toast.error(t.value.productDetail.loadError);
  }
}

const homePath = computed(() => `/${appStore.locale}`);
const imageSrc = computed(() => product.value?.image_url || product.value?.image || null);
const hasVideo = computed(() => !!product.value?.video_embed_url);

// Other products for the sidebar (exclude the current one)
const currentId = computed(() => String(route.params.id));
const otherProducts = computed(() =>
  (dataStore.products || []).filter((p: any) => String(p.id) !== currentId.value)
);
const hasOthers = computed(() => otherProducts.value.length > 0);

// Autoplay once the user explicitly presses play
const videoSrc = computed(() => {
  const url = product.value?.video_embed_url;
  if (!url) return '';
  return url.includes('youtube.com/embed/')
    ? `${url}${url.includes('?') ? '&' : '?'}autoplay=1`
    : url;
});

useHead({
  title: computed(() => product.value?.name || t.value.productDetail.description),
});

function playVideo() {
  showVideo.value = true;
}

async function loadProduct() {
  showVideo.value = false;
  try {
    await dataStore.fetchProduct(route.params.id as string, appStore.locale);
    // Load the list for the sidebar (translated to the current locale)
    await dataStore.fetchProducts(appStore.locale);
  } catch (error) {
    toast.error(t.value.productDetail.loadError);
  }
}

// Reload when the id or locale changes (locale switch re-fetches translated fields)
watch(
  () => [route.params.id, appStore.locale],
  () => {
    if (route.params.id) {
      loadProduct();
    }
  },
  { immediate: true }
);
</script>

<style scoped>
.product-detail-page {
  min-height: 100vh;
  background: #fff;
}

/* Styling for the TipTap rich-text HTML (no prose plugin installed) */
.product-description :deep(h1),
.product-description :deep(h2),
.product-description :deep(h3) {
  font-weight: 700;
  color: #1f2937;
  margin: 1rem 0 0.5rem;
}

.product-description :deep(h1) { font-size: 1.75rem; }
.product-description :deep(h2) { font-size: 1.4rem; }
.product-description :deep(h3) { font-size: 1.2rem; }

.product-description :deep(p) { margin-bottom: 0.75rem; }

.product-description :deep(ul),
.product-description :deep(ol) {
  padding-inline-start: 1.5rem;
  margin-bottom: 0.75rem;
}

.product-description :deep(ul) { list-style: disc; }
.product-description :deep(ol) { list-style: decimal; }

.product-description :deep(a) {
  color: #0d9488;
  text-decoration: underline;
}

.product-description :deep(blockquote) {
  border-inline-start: 3px solid #14b8a6;
  padding-inline-start: 1rem;
  color: #6b7280;
  font-style: italic;
  margin: 0.75rem 0;
}

.product-description :deep(img) {
  max-width: 100%;
  height: auto;
  border-radius: 0.75rem;
}
</style>
