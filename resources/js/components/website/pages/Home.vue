<template>
    <div class="home-page">
        <!-- Top Contact Bar -->
        <div class="flex items-center text-white font-bold justify-center p-4 gap-10 w-full bg-[#03315A]">
            <p class="[direction:ltr]"><i class="pi pi-phone text-white mx-2 text-[18px]"></i> +2 01022335566</p>
            <p class="[direction:ltr]"><i class="pi pi-envelope text-white mx-2 text-[18px]"></i> info@pulse-plus.com</p>
        </div>

        <!-- Navigation Desktop -->
        <nav class="hidden lg:flex py-4 px-20 bg-white/90 shadow-md justify-between items-center">
            <div class="flex items-center gap-4">
                <router-link to="/" class="text-2xl font-bold text-gray-800">
                    <img :src="logoImg" class="w-[120px]" alt="Pulse Logo">
                </router-link>
                <div>
                    <router-link to="/" class="mx-4 text-teal-500 transition duration-150 font-semibold before:w-full before:h-0.5 before:bg-teal-500 before:absolute before:-bottom-2 before:left-0 relative">الرئيسية</router-link>
                    <a href="#products" class="relative transition duration-150 font-semibold mx-4 hover:text-teal-500">المتجر</a>
                    <a href="#features" class="hover:text-teal-500 transition duration-150 font-semibold mx-4">خدماتنا</a>
                    <a href="#features" class="hover:text-teal-500 transition duration-150 font-semibold mx-4">من نحن</a>
                    <router-link to="/contact" class="hover:text-teal-500 transition duration-150 font-semibold mx-4">اتصل بنا</router-link>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <button class="flex items-center justify-center w-[50px] h-[50px] text-[18px] rounded-full shadow-xl">
                    <i class="pi pi-moon"></i>
                </button>
                <button class="flex items-center justify-center w-[50px] h-[50px] text-[18px] rounded-full shadow-xl">
                    EN
                </button>
                <router-link v-if="!isAuthenticated" to="/login" class="bg-teal-500 text-white px-5 py-2 rounded-[30px] shadow-lg font-semibold hover:bg-teal-600 transition duration-150">
                    تسجيل الدخول
                </router-link>
                <router-link v-else to="/profile" class="bg-teal-500 text-white px-5 py-2 rounded-[30px] shadow-lg font-semibold hover:bg-teal-600 transition duration-150">
                    الملف الشخصي
                </router-link>
            </div>
        </nav>

        <!-- Navigation Mobile -->
        <nav class="lg:hidden block w-full bg-white shadow-md px-6 py-4 flex items-center justify-between relative">
            <div>
                <router-link to="/">
                    <img :src="logoImg" class="w-[100px]" alt="Pulse Logo">
                </router-link>
            </div>
            <div class="flex items-center justify-center gap-4">
                <router-link v-if="isAuthenticated" to="/profile" class="w-9 h-9 rounded-full flex items-center justify-center bg-[#1BB2B1] cursor-pointer text-white shadow-xl">
                    <i class="pi pi-user"></i>
                </router-link>
                <button @click="toggleMenu" class="w-9 h-9 rounded-full flex items-center justify-center bg-[#FF6760] cursor-pointer text-white shadow-xl">
                    <i class="pi pi-bars"></i>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div v-if="menuOpen" class="absolute flex-col z-50 p-6 bg-white/80 top-[100%] left-0 backdrop-blur-md shadow-lg">
                <div>
                    <button class="bg-[#123057] rounded-4xl py-3 px-7 text-white cursor-pointer font-semibold">EN</button>
                    <button class="bg-[#123057] rounded-4xl py-3 px-7 text-white cursor-pointer font-semibold"><i class="pi pi-moon"></i></button>
                </div>
                <div>
                    <ul class="p-2 flex flex-col gap-2 text-right">
                        <li><router-link to="/" class="block py-2 px-3 rounded hover:bg-[#123057] hover:text-white transition-all">الرئيسية</router-link></li>
                        <li><a href="#products" class="block py-2 px-3 rounded hover:bg-[#123057] hover:text-white transition-all">المتجر</a></li>
                        <li><a href="#features" class="block py-2 px-3 rounded hover:bg-[#123057] hover:text-white transition-all">خدماتنا</a></li>
                        <li><a href="#features" class="block py-2 px-3 rounded hover:bg-[#123057] hover:text-white transition-all">من نحن</a></li>
                        <li><router-link to="/contact" class="block py-2 px-3 rounded hover:bg-[#123057] hover:text-white transition-all">اتصل بنا</router-link></li>
                    </ul>
                </div>
            </div>
        </nav>

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
                        <button class="flex items-center text-teal-500 font-semibold mt-4">
                            اطلب الان <i class="pi pi-arrow-circle-left mt-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-[#03315A] text-white">
            <div class="max-w-7xl mx-auto px-6 py-10 flex flex-col md:flex-row justify-between gap-8">
                <div class="md:w-1/3 flex justify-center md:justify-start text-center md:text-right">
                    <div class="w-full md:w-auto">
                        <div class="flex justify-center md:justify-start items-center gap-3 mb-3">
                            <img :src="footerLogoImg" class="w-[150px] md:w-[200px]" alt="Pulse Footer Logo">
                        </div>
                        <p class="text-sm">نحن نؤمن أن التكنولوجيا يجب أن تخدم الإنسانية، خصوصاً في لحظات الضعف والقوة</p>
                    </div>
                </div>

                <div class="md:w-1/3 flex justify-center">
                    <div>
                        <h3 class="font-semibold mb-2 text-center md:text-left">روابط سريعة</h3>
                        <ul class="space-y-1 text-sm text-center md:text-left">
                            <li><a href="#features" class="hover:text-teal-400 transition-colors">خدماتنا</a></li>
                            <li><a href="#products" class="hover:text-teal-400 transition-colors">المتجر</a></li>
                            <li><a href="#features" class="hover:text-teal-400 transition-colors">من نحن</a></li>
                        </ul>
                    </div>
                </div>

                <div class="md:w-1/3 flex justify-center md:justify-end text-center md:text-right">
                    <div>
                        <h3 class="font-semibold mb-2">تواصل معنا</h3>
                        <p class="text-sm">info@pulse-plus.com</p>
                        <p class="text-sm">+2 01022335566</p>
                    </div>
                </div>
            </div>

            <div class="border-t border-white/20 mt-6 py-4 text-center text-xs text-white/70">
                © 2024 Pulse+ جميع الحقوق محفوظة
            </div>
        </footer>
    </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, nextTick } from 'vue';
import { useHead } from '@vueuse/head';
import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

// Import images
import logoImg from '../../../images/website/logo.png';
import footerLogoImg from '../../../images/website/footer-logo.png';
import slideImg from '../../../images/website/slide.png';
import vector1Img from '../../../images/website/vector-1.png';
import vector2Img from '../../../images/website/vector-2.png';
import vector3Img from '../../../images/website/vector-3.png';
import product1Img from '../../../images/website/product-1.png';
import product2Img from '../../../images/website/product-2.png';

useHead({
    title: 'الرئيسية - Pulse',
});

const menuOpen = ref(false);

// Use window.authUser set by blade template
const isAuthenticated = computed(() => {
    return (window as any).authUser !== null && (window as any).authUser !== undefined;
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

const toggleMenu = () => {
    menuOpen.value = !menuOpen.value;
};

onMounted(() => {
    nextTick(() => {
        // Initialize Swiper
        new Swiper('.mySwiper', {
            modules: [Navigation, Pagination, Autoplay],
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

