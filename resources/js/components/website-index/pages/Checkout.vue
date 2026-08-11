<template>
  <div class="checkout-page" :dir="appStore.isRTL ? 'rtl' : 'ltr'">
    <Navigation />

    <!-- Title header -->
    <section class="relative bg-gradient-to-b from-teal-50 via-gray-50 to-white border-b border-gray-100 overflow-hidden">
      <div class="absolute -top-16 -end-16 w-56 h-56 bg-teal-100/50 rounded-full blur-3xl"></div>
      <div class="relative max-w-7xl mx-auto px-4 py-12 md:py-14 text-center">
        <h1 class="text-3xl md:text-5xl font-extrabold text-gray-800 tracking-tight">{{ t.checkout.title }}</h1>
        <div class="w-24 h-1.5 bg-teal-500 rounded-full mx-auto mt-5"></div>
      </div>
    </section>

    <section class="py-12 min-h-[45vh]">
      <div class="max-w-6xl mx-auto px-4">
        <!-- Success screen -->
        <div v-if="placedOrder" class="max-w-xl mx-auto text-center py-8">
          <div class="relative inline-flex items-center justify-center mb-6">
            <span class="absolute inline-flex h-28 w-28 rounded-full bg-teal-100 animate-ping opacity-60"></span>
            <span class="relative inline-flex items-center justify-center h-24 w-24 rounded-full bg-teal-500 text-white shadow-xl">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
              </svg>
            </span>
          </div>

          <h2 class="text-2xl md:text-3xl font-extrabold text-gray-800">{{ t.checkout.successTitle }}</h2>
          <p class="text-gray-500 mt-3 leading-relaxed">{{ t.checkout.successHint }}</p>

          <div class="inline-flex flex-col items-center gap-1 bg-teal-50 rounded-2xl px-8 py-4 mt-6">
            <span class="text-sm text-gray-500">{{ t.checkout.orderNo }}</span>
            <span class="text-xl font-bold text-teal-700 tracking-wide">{{ placedOrder.order_number }}</span>
            <span class="text-sm text-gray-500 mt-1">{{ placedOrder.total }} {{ t.cart.currency }}</span>
          </div>

          <div class="flex flex-wrap items-center justify-center gap-3 mt-8">
            <router-link
              v-if="isLoggedIn"
              :to="`/${appStore.locale}/profile?tab=orders`"
              class="inline-flex items-center gap-2 bg-teal-500 text-white font-semibold px-8 py-3 rounded-full shadow-lg hover:bg-teal-600 transition"
            >
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
              </svg>
              {{ t.checkout.viewOrders }}
            </router-link>
            <router-link
              :to="`/${appStore.locale}/products`"
              class="inline-flex items-center gap-2 font-semibold px-8 py-3 rounded-full transition"
              :class="isLoggedIn ? 'border border-teal-500 text-teal-600 hover:bg-teal-50' : 'bg-teal-500 text-white shadow-lg hover:bg-teal-600'"
            >
              {{ t.cart.continueShopping }}
            </router-link>
          </div>
        </div>

        <!-- Empty cart guard -->
        <div v-else-if="cartStore.loaded && cartStore.isEmpty" class="text-center py-16">
          <p class="text-xl text-gray-500 mb-6">{{ t.checkout.emptyCart }}</p>
          <router-link :to="`/${appStore.locale}/products`" class="inline-block bg-teal-500 text-white font-semibold px-8 py-3 rounded-full shadow-lg hover:bg-teal-600 transition">
            {{ t.cart.continueShopping }}
          </router-link>
        </div>

        <form v-else class="grid lg:grid-cols-3 gap-8" @submit.prevent="submit">
          <!-- Address form -->
          <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 space-y-5">
            <div class="grid md:grid-cols-2 gap-5">
              <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">{{ t.checkout.customerName }}</label>
                <input v-model="form.customer_name" type="text" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:border-teal-500" :class="{ 'border-red-400': errors.customer_name }">
                <span v-if="errors.customer_name" class="text-red-500 text-sm">{{ errors.customer_name[0] }}</span>
              </div>
              <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">{{ t.checkout.phone }}</label>
                <input v-model="form.customer_phone" type="tel" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:border-teal-500" :class="{ 'border-red-400': errors.customer_phone }">
                <span v-if="errors.customer_phone" class="text-red-500 text-sm">{{ errors.customer_phone[0] }}</span>
              </div>
            </div>

            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">{{ t.checkout.governorate }}</label>
              <SearchableSelect
                v-model="form.governorate_id"
                :options="governorateOptions"
                :placeholder="t.checkout.selectGovernorate"
                :search-placeholder="t.checkout.selectGovernorate"
                :invalid="!!errors.governorate_id"
              />
              <span v-if="errors.governorate_id" class="text-red-500 text-sm">{{ errors.governorate_id[0] }}</span>
            </div>

            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">{{ t.checkout.address }}</label>
              <textarea v-model="form.address" rows="3" :placeholder="t.checkout.addressPlaceholder" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:border-teal-500 resize-none" :class="{ 'border-red-400': errors.address }"></textarea>
              <span v-if="errors.address" class="text-red-500 text-sm">{{ errors.address[0] }}</span>
            </div>

            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">{{ t.checkout.notes }}</label>
              <textarea v-model="form.notes" rows="2" :placeholder="t.checkout.notesPlaceholder" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:border-teal-500 resize-none"></textarea>
            </div>

            <!-- Payment method (required) -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-3">{{ t.checkout.paymentMethod }} <span class="text-red-500">*</span></label>
              <div class="grid sm:grid-cols-2 gap-3">
                <label
                  v-for="method in paymentMethods"
                  :key="method.id"
                  class="relative flex items-center gap-3 border-2 rounded-2xl p-4 cursor-pointer transition"
                  :class="form.payment_method_id === method.id ? 'border-teal-500 bg-teal-50/50 shadow-sm' : 'border-gray-200 hover:border-teal-300'"
                >
                  <input type="radio" class="sr-only" :value="method.id" v-model="form.payment_method_id">
                  <span
                    class="w-5 h-5 rounded-full border-2 flex items-center justify-center flex-shrink-0"
                    :class="form.payment_method_id === method.id ? 'border-teal-500' : 'border-gray-300'"
                  >
                    <span v-if="form.payment_method_id === method.id" class="w-2.5 h-2.5 rounded-full bg-teal-500"></span>
                  </span>
                  <div class="w-12 h-12 rounded-lg bg-gray-50 flex items-center justify-center overflow-hidden flex-shrink-0">
                    <img v-if="method.image_url" :src="method.image_url" :alt="method.name" class="max-h-full max-w-full object-contain">
                    <svg v-else xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                  </div>
                  <div class="min-w-0">
                    <p class="font-semibold text-gray-800 truncate">{{ method.name }}</p>
                    <p v-if="method.description" class="text-xs text-gray-500 line-clamp-1">{{ method.description }}</p>
                  </div>
                </label>
              </div>
              <span v-if="errors.payment_method_id" class="text-red-500 text-sm">{{ errors.payment_method_id[0] }}</span>

              <!-- Receipt upload (only when the selected method requires it) -->
              <div v-if="selectedPaymentMethod?.requires_receipt" class="mt-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">{{ t.checkout.receipt }} <span class="text-red-500">*</span></label>
                <input
                  type="file"
                  accept="image/*,.pdf"
                  class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:border-teal-500 text-sm file:me-3 file:rounded-lg file:border-0 file:bg-teal-50 file:px-3 file:py-1.5 file:text-teal-600 file:font-semibold"
                  :class="errors.receipt ? 'border-red-400' : 'border-gray-200'"
                  @change="onReceipt"
                >
                <p class="text-xs text-gray-400 mt-1">{{ t.checkout.receiptHint }}</p>
                <p v-if="receiptName" class="text-sm text-teal-600 mt-1">{{ receiptName }}</p>
                <span v-if="errors.receipt" class="text-red-500 text-sm">{{ errors.receipt[0] }}</span>
              </div>
            </div>
          </div>

          <!-- Order summary -->
          <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:sticky lg:top-24">
              <h2 class="font-bold text-gray-800 mb-4">{{ t.checkout.orderSummary }}</h2>

              <div class="space-y-2 mb-4">
                <div v-for="item in cartStore.items" :key="item.id" class="flex justify-between text-sm text-gray-600">
                  <span class="truncate me-2">{{ item.name }} × {{ item.quantity }}</span>
                  <span class="whitespace-nowrap">{{ item.line_total }} {{ t.cart.currency }}</span>
                </div>
              </div>

              <!-- Promo code -->
              <div class="border-t border-gray-100 pt-4 mb-2">
                <label class="block text-sm font-semibold text-gray-700 mb-2">{{ t.checkout.promoTitle }}</label>
                <div v-if="!appliedCoupon" class="flex gap-2">
                  <input
                    v-model="couponCode"
                    type="text"
                    :placeholder="t.checkout.promoPlaceholder"
                    class="flex-1 min-w-0 border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:border-teal-500"
                    :class="{ 'border-red-400': couponError }"
                    @keyup.enter.prevent="applyCoupon"
                  >
                  <button
                    type="button"
                    class="shrink-0 bg-gray-800 text-white font-semibold px-4 py-2.5 rounded-xl hover:bg-gray-900 transition disabled:opacity-60"
                    :disabled="applyingCoupon || !couponCode.trim()"
                    @click="applyCoupon"
                  >
                    {{ t.checkout.promoApply }}
                  </button>
                </div>
                <div v-else class="flex items-center justify-between bg-teal-50 rounded-xl px-4 py-2.5">
                  <span class="font-semibold text-teal-700">{{ appliedCoupon.code }}</span>
                  <button type="button" class="text-sm text-red-500 hover:text-red-600 font-semibold" @click="removeCoupon">
                    {{ t.checkout.promoRemove }}
                  </button>
                </div>
                <span v-if="couponError" class="text-red-500 text-sm">{{ couponError }}</span>
              </div>

              <div class="border-t border-gray-100 pt-4 space-y-2">
                <div class="flex justify-between text-gray-600">
                  <span>{{ t.checkout.subtotal }}</span>
                  <span class="font-semibold">{{ cartStore.subtotal }} {{ t.cart.currency }}</span>
                </div>
                <div v-if="discount > 0" class="flex justify-between text-teal-600">
                  <span>{{ t.checkout.discount }}</span>
                  <span class="font-semibold">- {{ discount }} {{ t.cart.currency }}</span>
                </div>
                <div class="flex justify-between text-gray-600">
                  <span>{{ t.checkout.shipping }}</span>
                  <span class="font-semibold" v-if="selectedGovernorate">{{ shippingPrice }} {{ t.cart.currency }}</span>
                  <span class="text-xs text-gray-400" v-else>{{ t.checkout.selectGovFirst }}</span>
                </div>
                <div class="flex justify-between text-lg font-bold text-gray-800 border-t border-gray-100 pt-3">
                  <span>{{ t.checkout.total }}</span>
                  <span class="text-teal-600">{{ total }} {{ t.cart.currency }}</span>
                </div>
              </div>

              <button
                type="submit"
                class="w-full mt-6 bg-teal-500 text-white font-semibold py-3 rounded-xl shadow-lg hover:bg-teal-600 transition disabled:opacity-60 text-center flex items-center justify-center"
                :disabled="submitting || cartStore.isEmpty"
              >
                {{ submitting ? t.checkout.placing : t.checkout.placeOrder }}
              </button>
            </div>
          </div>
        </form>
      </div>
    </section>

    <Footer />
  </div>
</template>

<script setup lang="ts">
import { computed, onMounted, reactive, ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
import { useHead } from '@vueuse/head';
import { useToast } from 'vue-toastification';
import { useAppStore } from '../../../stores/website-index/appStore';
import { useCartStore } from '../../../stores/website-index/cartStore';
import Navigation from '../../website/Navigation.vue';
import Footer from '../Footer.vue';
import SearchableSelect from '../SearchableSelect.vue';

const appStore = useAppStore();
const cartStore = useCartStore();
const router = useRouter();
const toast = useToast();

const t = computed(() => appStore.t);
const isLoggedIn = computed(() => !!sessionStorage.getItem('user'));

const governorateOptions = computed(() =>
  governorates.value.map((g: any) => ({
    value: g.id,
    label: `${g.name} — ${g.delivery_price} ${t.value.cart.currency}`,
  }))
);

const governorates = ref<any[]>([]);
const paymentMethods = ref<any[]>([]);
const submitting = ref(false);
const placedOrder = ref<any>(null);
const errors = reactive<Record<string, string[]>>({});

const form = reactive({
  customer_name: '',
  customer_phone: '',
  governorate_id: null as number | null,
  payment_method_id: null as number | null,
  address: '',
  notes: '',
});

const selectedGovernorate = computed(() =>
  governorates.value.find((g) => g.id === form.governorate_id) || null
);
const selectedPaymentMethod = computed(() =>
  paymentMethods.value.find((m) => m.id === form.payment_method_id) || null
);
const receiptFile = ref<File | null>(null);
const receiptName = ref('');

function onReceipt(event: any) {
  const file = event.target.files[0];
  receiptFile.value = file || null;
  receiptName.value = file ? file.name : '';
}
const shippingPrice = computed(() => selectedGovernorate.value ? Number(selectedGovernorate.value.delivery_price) : 0);

// Promo code
const couponCode = ref('');
const appliedCoupon = ref<{ code: string; discount: number } | null>(null);
const applyingCoupon = ref(false);
const couponError = ref('');

const discount = computed(() => appliedCoupon.value ? Number(appliedCoupon.value.discount) : 0);
const total = computed(() =>
  Number(Math.max(0, Number(cartStore.subtotal) - discount.value + shippingPrice.value).toFixed(2))
);

async function applyCoupon() {
  const code = couponCode.value.trim();
  if (!code) {
    return;
  }
  applyingCoupon.value = true;
  couponError.value = '';
  try {
    const response = await axios.post('/api/website/coupons/validate', { code }, {
      headers: { 'Accept-Language': appStore.locale },
    });
    appliedCoupon.value = {
      code: response.data.data.code,
      discount: Number(response.data.data.discount),
    };
    toast.success(t.value.checkout.promoApplied);
  } catch (error: any) {
    appliedCoupon.value = null;
    couponError.value = error?.response?.data?.message || t.value.checkout.promoInvalid;
  } finally {
    applyingCoupon.value = false;
  }
}

function removeCoupon() {
  appliedCoupon.value = null;
  couponCode.value = '';
  couponError.value = '';
}

useHead({ title: computed(() => t.value.checkout.title) });

async function fetchGovernorates() {
  try {
    const response = await axios.get('/api/website/governorates', {
      headers: { 'Accept-Language': appStore.locale },
    });
    governorates.value = response.data.data || [];
  } catch (error) {
    governorates.value = [];
  }
}

async function fetchPaymentMethods() {
  try {
    const response = await axios.get('/api/website/payment-methods', {
      headers: { 'Accept-Language': appStore.locale },
    });
    paymentMethods.value = response.data.data || [];
    // Preselect the first method for convenience
    if (paymentMethods.value.length && !form.payment_method_id) {
      form.payment_method_id = paymentMethods.value[0].id;
    }
  } catch (error) {
    paymentMethods.value = [];
  }
}

function prefillFromUser() {
  try {
    const user = JSON.parse(sessionStorage.getItem('user') || 'null');
    if (user) {
      form.customer_name = user.name || '';
      form.customer_phone = user.phone || '';
      form.address = user.address || '';
    }
  } catch (e) { /* ignore */ }
}

async function submit() {
  Object.keys(errors).forEach((k) => delete errors[k]);
  submitting.value = true;
  try {
    const data = new FormData();
    Object.entries(form).forEach(([key, value]) => {
      if (value !== null && value !== undefined) {
        data.append(key, value as string);
      }
    });
    if (appliedCoupon.value) {
      data.append('coupon_code', appliedCoupon.value.code);
    }
    if (receiptFile.value) {
      data.append('receipt', receiptFile.value);
    }
    const response = await axios.post('/api/website/checkout', data, {
      headers: { 'Accept-Language': appStore.locale },
    });
    cartStore.reset();
    placedOrder.value = response.data.data;
    toast.success(t.value.checkout.success);
    window.scrollTo({ top: 0, behavior: 'smooth' });
  } catch (error: any) {
    if (error?.response?.status === 422) {
      Object.assign(errors, error.response.data.errors || {});
    }
    toast.error(error?.response?.data?.message || t.value.checkout.emptyCart);
  } finally {
    submitting.value = false;
  }
}

onMounted(async () => {
  prefillFromUser();
  await Promise.all([cartStore.fetchCart(), fetchGovernorates(), fetchPaymentMethods()]);
});
</script>

<style scoped>
.checkout-page {
  min-height: 100vh;
  background: #fff;
}
</style>
