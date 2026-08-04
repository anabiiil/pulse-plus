<template>
  <div>
    <!-- Loading -->
    <div v-if="loading" class="flex items-center justify-center py-16">
      <div class="animate-spin rounded-full h-14 w-14 border-b-2 border-teal-500"></div>
    </div>

    <!-- Empty -->
    <div v-else-if="!orders.length" class="text-center py-14 text-gray-500 text-lg">
      {{ t.orders.empty }}
    </div>

    <!-- Orders list -->
    <div v-else class="space-y-4">
      <div
        v-for="order in orders"
        :key="order.id"
        class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex flex-wrap items-center gap-4"
      >
        <div class="flex-1 min-w-[160px]">
          <p class="font-bold text-gray-800">{{ order.order_number }}</p>
          <p class="text-sm text-gray-500 mt-1">{{ order.created_at }}</p>
        </div>
        <span class="px-3 py-1 rounded-full text-xs font-bold text-white" :class="statusColor(order.status)">
          {{ statusLabel(order.status) }}
        </span>
        <div class="text-end">
          <p class="font-bold text-teal-600">{{ order.total }} {{ t.cart.currency }}</p>
        </div>
        <button
          type="button"
          class="border border-teal-500 text-teal-600 font-semibold px-4 py-2 rounded-xl hover:bg-teal-50 transition"
          @click="openDetails(order.id)"
        >
          {{ t.orders.viewDetails }}
        </button>
      </div>
    </div>

    <!-- Details modal -->
    <div v-if="detailOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4" @click.self="detailOpen = false">
      <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>
      <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-2xl max-h-[88vh] overflow-y-auto" :dir="appStore.isRTL ? 'rtl' : 'ltr'">
        <div v-if="detailLoading" class="flex items-center justify-center py-20">
          <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-teal-500"></div>
        </div>

        <template v-else-if="detail">
          <!-- Header -->
          <div class="relative bg-gradient-to-br from-teal-500 to-cyan-500 text-white p-6">
            <button type="button" class="absolute top-4 end-4 text-white/80 hover:text-white" @click="detailOpen = false">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
            <p class="text-white/80 text-sm">{{ t.orders.orderNumber }}</p>
            <h2 class="text-2xl font-extrabold tracking-wide">{{ detail.order_number }}</h2>
            <div class="flex items-center gap-3 mt-3">
              <span class="px-3 py-1 rounded-full text-xs font-bold bg-white/20 backdrop-blur">{{ statusLabel(detail.status) }}</span>
              <span class="text-white/80 text-sm">{{ detail.created_at }}</span>
            </div>
          </div>

          <div class="p-6 space-y-6">
            <!-- Items -->
            <div>
              <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                <span class="w-1.5 h-5 bg-teal-500 rounded-full"></span>{{ t.orders.items }}
              </h3>
              <div class="divide-y divide-gray-100 rounded-2xl border border-gray-100">
                <div v-for="item in detail.items" :key="item.id" class="flex items-center justify-between gap-3 p-3">
                  <div class="min-w-0">
                    <p class="font-semibold text-gray-800 truncate">{{ item.product_name }}</p>
                    <p class="text-xs text-gray-500">{{ item.quantity }} × {{ item.product_price }} {{ t.cart.currency }}</p>
                  </div>
                  <p class="font-bold text-gray-800 whitespace-nowrap">{{ item.line_total }} {{ t.cart.currency }}</p>
                </div>
              </div>
            </div>

            <!-- Shipping + payment -->
            <div class="grid sm:grid-cols-2 gap-4">
              <div class="bg-gray-50 rounded-2xl p-4">
                <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                  <span class="w-1.5 h-5 bg-teal-500 rounded-full"></span>{{ t.orders.shippingInfo }}
                </h3>
                <ul class="space-y-1.5 text-sm text-gray-600">
                  <li><span class="text-gray-400">{{ t.checkout.customerName }}:</span> {{ detail.customer_name }}</li>
                  <li><span class="text-gray-400">{{ t.checkout.phone }}:</span> {{ detail.customer_phone }}</li>
                  <li><span class="text-gray-400">{{ t.checkout.governorate }}:</span> {{ detail.governorate_name }}</li>
                  <li><span class="text-gray-400">{{ t.checkout.address }}:</span> {{ detail.address }}</li>
                </ul>
              </div>

              <div class="bg-gray-50 rounded-2xl p-4">
                <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                  <span class="w-1.5 h-5 bg-teal-500 rounded-full"></span>{{ t.checkout.paymentMethod }}
                </h3>
                <div class="flex items-center gap-3">
                  <div class="w-11 h-11 rounded-xl bg-white border border-gray-100 flex items-center justify-center overflow-hidden flex-shrink-0">
                    <img v-if="detail.payment_method_image" :src="detail.payment_method_image" class="max-h-full max-w-full object-contain" alt="">
                    <svg v-else xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                  </div>
                  <span class="font-semibold text-gray-800">{{ detail.payment_method_name || '—' }}</span>
                </div>
                <a
                  v-if="detail.receipt_url"
                  :href="detail.receipt_url"
                  target="_blank"
                  class="inline-flex items-center gap-2 mt-3 text-sm text-teal-600 font-semibold hover:text-teal-700"
                >
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                  </svg>
                  {{ t.checkout.receipt }}
                </a>
              </div>
            </div>

            <!-- Totals -->
            <div class="bg-teal-50/60 rounded-2xl p-4 space-y-2">
              <div class="flex justify-between text-gray-600 text-sm">
                <span>{{ t.orders.subtotal }}</span>
                <span class="font-semibold">{{ detail.subtotal }} {{ t.cart.currency }}</span>
              </div>
              <div class="flex justify-between text-gray-600 text-sm">
                <span>{{ t.orders.shipping }}</span>
                <span class="font-semibold">{{ detail.shipping_price }} {{ t.cart.currency }}</span>
              </div>
              <div class="flex justify-between text-lg font-extrabold text-gray-800 border-t border-teal-100 pt-2">
                <span>{{ t.orders.total }}</span>
                <span class="text-teal-600">{{ detail.total }} {{ t.cart.currency }}</span>
              </div>
            </div>
          </div>
        </template>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed, onMounted, ref } from 'vue';
import axios from 'axios';
import { useAppStore } from '../../stores/website-index/appStore';

const appStore = useAppStore();
const t = computed(() => appStore.t);

const orders = ref<any[]>([]);
const loading = ref(true);
const detailOpen = ref(false);
const detailLoading = ref(false);
const detail = ref<any>(null);

const STATUS_COLORS: Record<string, string> = {
  pending: 'bg-amber-500',
  confirmed: 'bg-sky-500',
  in_progress: 'bg-indigo-500',
  on_way: 'bg-purple-500',
  completed: 'bg-green-500',
  canceled: 'bg-red-500',
  canceled_by_client: 'bg-red-400',
};

function statusColor(status: string) {
  return STATUS_COLORS[status] || 'bg-gray-400';
}

function statusLabel(status: string) {
  return (t.value.orders.statuses as Record<string, string>)[status] || status;
}

async function fetchOrders() {
  loading.value = true;
  try {
    const response = await axios.get('/api/website/orders', {
      headers: { 'Accept-Language': appStore.locale },
    });
    orders.value = response.data.data || [];
  } catch (error) {
    orders.value = [];
  } finally {
    loading.value = false;
  }
}

async function openDetails(id: number) {
  detailOpen.value = true;
  detailLoading.value = true;
  detail.value = null;
  try {
    const response = await axios.get(`/api/website/orders/${id}`, {
      headers: { 'Accept-Language': appStore.locale },
    });
    detail.value = response.data.data;
  } catch (error) {
    detailOpen.value = false;
  } finally {
    detailLoading.value = false;
  }
}

onMounted(fetchOrders);
</script>
