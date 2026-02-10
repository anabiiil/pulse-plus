<template>
    <div class="home-page">
        <!-- Navigation -->
        <Navigation />

        <!-- Hero Slider -->
        <section class="w-full h-[70vh]">
            <div class="swiper mySwiper w-full h-full">
                <div class="swiper-wrapper">
                    <div v-for="(slide, index) in slides" :key="index" class="swiper-slide relative">
                        <img :src="slide.image" class="w-full h-full object-cover" :alt="slide.title" />
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
            <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-8 px-4">
                <div class="p-10">
                    <div class="bg-gray-50 flex items-center justify-center h-[320px] p-10 rounded-3xl shadow-xl transform transition duration-500 hover:scale-105 hover:shadow-2xl cursor-pointer relative overflow-hidden">
                        <img :src="product2Img" class="w-[240px]" alt="Medical Bracelet">
                    </div>
                    <div class="p-2 text-center">
                        <h3 class="text-xl font-bold mt-4">السوار الطبي</h3>
<!--                        <button class="flex items-center text-teal-500 font-semibold mt-4">-->
<!--                            اطلب الان <i class="pi pi-arrow-circle-left mt-2"></i>-->
<!--                        </button>-->
                    </div>
                </div>
                <div class="p-10">
                    <div class="bg-gray-50 flex items-center justify-center h-[320px] p-10 rounded-3xl shadow-xl transform transition duration-500 hover:scale-105 hover:shadow-2xl cursor-pointer relative overflow-hidden">
                        <img :src="product1Img" class="w-[240px]" alt="Smart Chain">
                    </div>
                    <div class="p-2 text-center">
                        <h3 class="text-xl font-bold mt-4">السلسلة الذكية</h3>
<!--                        <button class="flex items-center text-teal-500 font-semibold mt-4">-->
<!--                            اطلب الان <i class="pi pi-arrow-circle-left mt-2"></i>-->
<!--                        </button>-->
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <Footer />
    </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, nextTick } from 'vue';
import { useHead } from '@vueuse/head';
import Swiper from 'swiper';
import { Navigation as SwiperNavigation, Pagination, Autoplay } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

// Import components
import Navigation from '../Navigation.vue';
import Footer from '../Footer.vue';

// Import images
import slideImg from '../../../images/website/slide.png';
import vector1Img from '../../../images/website/vector-1.png';
import vector2Img from '../../../images/website/vector-2.png';
import vector3Img from '../../../images/website/vector-3.png';
import product1Img from '../../../images/website/product-1.png';
import product2Img from '../../../images/website/product-2.png';

useHead({
    title: 'الرئيسية - Pulse',
});


const slides = ref([
    {
        image: slideImg,
        title: 'NFC WRISTBAND',
        description: 'Your digital business card, on your wrist with the latest NFC technology'
    },
    {
        image: slideImg,
        title: 'NFC WRISTBAND',
        description: 'Your digital business card, on your wrist with the latest NFC technology'
    },
    {
        image: slideImg,
        title: 'NFC WRISTBAND',
        description: 'Your digital business card, on your wrist with the latest NFC technology'
    }
]);


onMounted(() => {
    nextTick(() => {
        // Initialize Swiper
        new Swiper('.mySwiper', {
            modules: [SwiperNavigation, Pagination, Autoplay],
            loop: true,
            speed: 900,
            autoplay: {
                delay: 3500,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });
    });
});
</script>

