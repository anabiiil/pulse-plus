<template>
    <div class="login-page">
        <!-- Navigation -->
        <Navigation />

        <!-- Login Form Section -->
        <div class="bg-gray-50 min-h-[70vh] py-16">
            <div class="flex flex-col items-center justify-center text-center px-4">
                <h1 class="text-3xl font-bold text-[#123057] mb-2">
                    مرحباً بك مجدداً
                </h1>
                <p class="text-sm font-semibold text-gray-500 mb-6">
                    ادخل إلى خزنتك الطبية الآمنة
                </p>

                <div class="w-25 h-25 my-6 animate-[float_3s_ease-in-out_infinite]">
                    <img :src="shieldImg" alt="icon" class="w-full h-full object-contain m-auto" style="width:80px"/>
                </div>

                <!-- Login Form Component -->
                <LoginForm />

                <p class="text-xs text-gray-400 mt-6">
                    © 2025 Pulse+ جميع الحقوق محفوظة
                </p>
            </div>
        </div>

        <!-- Footer -->
        <Footer />
    </div>
</template>

<script setup lang="ts">
import { useHead } from '@vueuse/head';

// Import components
import Navigation from '../Navigation.vue';
import Footer from '../Footer.vue';
import LoginForm from '../forms/LoginForm.vue';

// Import images
import shieldImg from '../../../images/website/shield.png';

useHead({
    title: 'تسجيل الدخول - Pulse',
});
</script>

<style scoped>
@keyframes float {
    0%, 100% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-20px);
    }
}
</style>
