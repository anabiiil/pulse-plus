<template>
    <div class="home-page">
        <!-- Navigation -->
        <Navigation />

        <!-- Loading State -->
        <div v-if="loading" class="flex items-center justify-center min-h-screen">
            <div class="animate-spin rounded-full h-16 w-16 border-b-2 border-teal-500"></div>
        </div>

        <!-- Error State -->
        <div v-else-if="error" class="flex items-center justify-center min-h-screen">
            <div class="text-center">
                <p class="text-red-600 text-xl mb-4">{{ error }}</p>
                <button @click="fetchHomeData()" class="bg-teal-500 text-white px-6 py-2 rounded-lg hover:bg-teal-600">
                    إعادة المحاولة
                </button>
            </div>
        </div>

        <!-- Content -->
        <div v-else>
            <!-- Hero Slider -->
            <section v-if="sliders.length > 0" class="w-full h-[70vh]">
                <div class="swiper mySwiper w-full h-full">
                    <div class="swiper-wrapper">
                        <div v-for="(slide, index) in sliders" :key="index" class="swiper-slide relative">
                            <img :src="slide.image_url" class="w-full h-full object-cover" :alt="slide.title" />
                            <div class="absolute inset-0 flex items-end justify-start [direction:ltr]">
                                <div class="hidden lg:block px-20 pb-20 max-w-xl">
                                    <h2 class="text-5xl font-extrabold text-black mb-4">{{ slide.title }}</h2>
                                    <p class="text-gray-600 text-lg mb-6">{{ slide.description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </section>

            <!-- Features Section -->
            <section id="features" class="py-16 bg-gray-50">
                <div class="max-w-6xl mx-auto text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-800">لماذا تختار Pulse+ ؟</h2>
                </div>

                <div class="max-w-6xl mx-auto grid lg:grid-cols-3 grid-cols-1 gap-8 px-4">
                    <div class="bg-white text-center p-6 rounded-3xl shadow-xl transform transition duration-500 hover:scale-105 hover:shadow-2xl cursor-pointer relative overflow-hidden">
                        <div class="flex items-center justify-center">
                            <img :src="vector1Img" class="w-[60px] m-4" alt="Security">
                        </div>
                        <h3 class="text-xl px-10 font-bold mb-2">أمان وخصوصية</h3>
                        <p class="text-gray-600 text-[14px] font-semibold px-10">تحكم كامل في المعلومات التي تظهر للعموم والمعلومات المخصصة للطوارئ</p>
                    </div>

                    <div class="bg-white text-center p-6 rounded-3xl shadow-xl transform transition duration-500 hover:scale-105 hover:shadow-2xl cursor-pointer relative overflow-hidden">
                        <div class="flex items-center justify-center">
                            <img :src="vector2Img" class="w-[60px] m-4" alt="Support">
                        </div>
                        <h3 class="text-lg px-10 font-bold mb-2">دعم مرضى الزهايمر ومتلازمة داون</h3>
                        <p class="text-gray-600 text-[14px] font-semibold px-10">سهولة الوصول لأرقام الطوارئ في حال تاه الشخص أو التعرض لحادث</p>
                    </div>

                    <div class="bg-white text-center p-6 rounded-3xl shadow-xl transform transition duration-500 hover:scale-105 hover:shadow-2xl cursor-pointer relative overflow-hidden">
                        <div class="flex items-center justify-center">
                            <img :src="vector3Img" class="w-[60px] m-4" alt="Technology">
                        </div>
                        <h3 class="text-lg px-10 font-bold mb-2">تقنية NFC و QR</h3>
                        <p class="text-gray-600 text-[14px] font-semibold px-10">وصول فوري للملف الطبي من خلال لمس السوار بالهاتف أو مسح الرمز</p>
                    </div>
                </div>
            </section>

            <!-- Products Section -->
            <section id="products" class="py-16">
                <div class="max-w-6xl mx-auto text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-800">اختر الأمان الذي يناسبك</h2>
                </div>
                <div v-if="products.length > 0" class="max-w-6xl mx-auto grid md:grid-cols-2 gap-8 px-4">
                    <div v-for="product in products" :key="product.id" class="p-10">
                        <div class="bg-gray-50 flex items-center justify-center h-[320px] p-10 rounded-3xl shadow-xl transform transition duration-500 hover:scale-105 hover:shadow-2xl cursor-pointer relative overflow-hidden">
                            <img :src="product.image_url" class="w-[240px]" :alt="product.name">
                        </div>
                        <div class="p-2 text-center">
                            <h3 class="text-xl font-bold mt-4">{{ product.name }}</h3>
                            <p class="text-gray-600 mt-2">{{ product.description }}</p>
                        </div>
                    </div>
                </div>
                <!-- Fallback to static products if no products from API -->
                <div v-else class="max-w-6xl mx-auto grid md:grid-cols-2 gap-8 px-4">
                    <div class="p-10">
                        <div class="bg-gray-50 flex items-center justify-center h-[320px] p-10 rounded-3xl shadow-xl transform transition duration-500 hover:scale-105 hover:shadow-2xl cursor-pointer relative overflow-hidden">
                            <img :src="product2Img" class="w-[240px]" alt="Medical Bracelet">
                        </div>
                        <div class="p-2 text-center">
                            <h3 class="text-xl font-bold mt-4">السوار الطبي</h3>
                        </div>
                    </div>
                    <div class="p-10">
                        <div class="bg-gray-50 flex items-center justify-center h-[320px] p-10 rounded-3xl shadow-xl transform transition duration-500 hover:scale-105 hover:shadow-2xl cursor-pointer relative overflow-hidden">
                            <img :src="product1Img" class="w-[240px]" alt="Smart Chain">
                        </div>
                        <div class="p-2 text-center">
                            <h3 class="text-xl font-bold mt-4">السلسلة الذكية</h3>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Services Section (if needed) -->
            <section v-if="services.length > 0" id="services" class="py-16 bg-gray-50">
                <div class="max-w-6xl mx-auto text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-800">خدماتنا</h2>
                </div>
                <div class="max-w-6xl mx-auto grid lg:grid-cols-3 grid-cols-1 gap-8 px-4">
                    <div v-for="service in services" :key="service.id" class="bg-white text-center p-6 rounded-3xl shadow-xl transform transition duration-500 hover:scale-105 hover:shadow-2xl cursor-pointer">
                        <div class="flex items-center justify-center mb-4">
                            <img :src="service.image_url" class="w-[80px] h-[80px] object-cover rounded-full" :alt="service.name">
                        </div>
                        <h3 class="text-xl font-bold mb-2">{{ service.name }}</h3>
                        <p class="text-gray-600 text-[14px]">{{ service.description }}</p>
                    </div>
                </div>
            </section>
        </div>

        <!-- Footer -->
        <Footer />
    </div>
</template>

<script setup lang="ts">
import { computed, onMounted, nextTick } from 'vue';
import { useHead } from '@vueuse/head';
import Swiper from 'swiper';
import { Navigation as SwiperNavigation, Pagination, Autoplay } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

// Import components
import Navigation from '../Navigation.vue';
import Footer from '../Footer.vue';

// Import composable
import { useHomeData } from '@/composables/useHomeData';

// Import images (fallback)
import vector1Img from '../../../images/website/vector-1.png';
import vector2Img from '../../../images/website/vector-2.png';
import vector3Img from '../../../images/website/vector-3.png';
import product1Img from '../../../images/website/product-1.png';
import product2Img from '../../../images/website/product-2.png';

useHead({
    title: 'الرئيسية - Pulse',
});

// Use home data composable
const { homeData, loading, error, fetchHomeData } = useHomeData();

// Computed properties
const sliders = computed(() => homeData.value?.sliders || []);
const products = computed(() => homeData.value?.products || []);
const services = computed(() => homeData.value?.services || []);

// Initialize Swiper instance
let swiperInstance: Swiper | null = null;

const initSwiper = () => {
    nextTick(() => {
        if (sliders.value.length > 0) {
            // Destroy existing instance if any
            if (swiperInstance) {
                swiperInstance.destroy(true, true);
            }

            // Initialize new Swiper
            swiperInstance = new Swiper('.mySwiper', {
                modules: [SwiperNavigation, Pagination, Autoplay],
                loop: sliders.value.length > 1,
                speed: 900,
                autoplay: sliders.value.length > 1 ? {
                    delay: 3500,
                    disableOnInteraction: false,
                } : false,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
            });
        }
    });
};

onMounted(async () => {
    try {
        // Fetch home data with custom limits
        await fetchHomeData({
            slider_limit: 5,
            product_limit: 6,
            service_limit: 6,
        });

        // Initialize Swiper after data is loaded
        initSwiper();
    } catch (err) {
        console.error('Failed to load home data:', err);
    }
});
</script>






