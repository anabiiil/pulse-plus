<template>
    <div class="login-page">
        <!-- Navigation -->
        <Navigation />

        <!-- Login Form -->
        <div class="bg-gray-50 min-h-[70vh] py-16">
            <div class="flex flex-col items-center justify-center text-center px-4">
                <h1 class="text-3xl font-bold text-[#123057] mb-2">
                    مرحباً بك مجدداً
                </h1>
                <p class="text-sm font-semibold text-gray-500 mb-6">
                    ادخل إلى خزنتك الطبية الآمنة
                </p>

                <div class="w-25 h-25 my-6 animate-[float_3s_ease-in-out_infinite]">
                    <img :src="shieldImg" alt="icon" class="w-full h-full object-contain" />
                </div>

                <div class="w-full max-w-sm bg-white rounded-2xl shadow-xl p-6">
                    <form @submit.prevent="handleLogin">
                        <div class="mb-4 text-right">
                            <label class="block font-semibold text-gray-700 mb-2">
                                البريد الإلكتروني
                            </label>
                            <div class="relative">
                                <i class="pi pi-envelope absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
                                <input
                                    v-model="formData.email"
                                    type="email"
                                    class="focus-visible:outline-none focus-visible:ring-0 focus:ring-0 focus:border-transparent bg-gray-50 border-0 transition duration-300 ease-in-out hover:shadow-2xl cursor-pointer shadow-xl font-semibold rounded-[20px] w-full p-4 my-2 pr-12"
                                    placeholder="example@mail.com"
                                    required
                                />
                                <p v-if="errors.email" class="text-red-500 text-sm mt-1 text-right">{{ errors.email }}</p>
                            </div>
                        </div>

                        <div class="mb-2 text-right">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                كلمة المرور
                            </label>
                            <div class="relative">
                                <i class="pi pi-lock absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
                                <input
                                    v-model="formData.password"
                                    :type="showPassword ? 'text' : 'password'"
                                    class="focus-visible:outline-none focus-visible:ring-0 focus:ring-0 focus:border-transparent bg-gray-50 border-0 transition duration-300 ease-in-out hover:shadow-2xl cursor-pointer shadow-xl font-semibold rounded-[20px] w-full p-4 my-2 pr-12"
                                    placeholder="*********"
                                    required
                                />
                                <button
                                    type="button"
                                    @click="showPassword = !showPassword"
                                    class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500"
                                >
                                    <i :class="showPassword ? 'pi pi-eye' : 'pi pi-eye-slash'"></i>
                                </button>
                                <p v-if="errors.password" class="text-red-500 text-sm mt-1 text-right">{{ errors.password }}</p>
                            </div>
                        </div>

                        <div class="text-center mb-4">
                            <a href="#" class="text-sm mb-2 text-teal-600 hover:underline">
                                نسيت كلمة المرور؟
                            </a>
                        </div>

                        <button
                            type="submit"
                            :disabled="loading"
                            class="px-15 flex items-center justify-center mx-auto gap-2 bg-[#00A5AA] hover:bg-teal-700 text-white py-3 rounded-xl rounded-2xl font-medium transition disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <svg v-if="!loading" width="18" height="21" viewBox="0 0 18 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M3.375 17.39L9 20.64V20.645L14.625 17.395C15.6498 16.8012 16.5009 15.9489 17.0931 14.9232C17.6854 13.8975 17.9981 12.7344 18 11.55V3.375C18 2.81 17.62 2.31 17.075 2.165L9 0L0.925 2.16C0.38 2.31 0 2.805 0 3.37V11.545C0.00193546 12.7294 0.31465 13.8925 0.906899 14.9182C1.49915 15.9439 2.35019 16.7962 3.375 17.39ZM1.5 11.545V3.56L9 1.55L16.5 3.56V11.545C16.4987 12.4661 16.2556 13.3707 15.7949 14.1683C15.3342 14.9659 14.6722 15.6286 13.875 16.09L9 18.905L4.125 16.09C3.32782 15.6286 2.66578 14.9659 2.20511 14.1683C1.74444 13.3707 1.5013 12.4661 1.5 11.545ZM6.866 12.2C7.111 12.445 7.431 12.565 7.751 12.565C8.071 12.565 8.391 12.445 8.636 12.2L13.78 7.055L12.72 5.995L7.75 10.965L5.78 8.995L4.72 10.055L6.865 12.2H6.866Z" fill="white"/>
                            </svg>
                            <span v-if="loading" class="inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                            تسجيل الدخول
                        </button>
                    </form>
                </div>

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
import { ref, reactive } from 'vue';
import { useHead } from '@vueuse/head';
import { useRouter } from 'vue-router';
import { useToast } from 'vue-toastification';
import axios from 'axios';

// Import components
import Navigation from '../Navigation.vue';
import Footer from '../Footer.vue';

// Import images
import shieldImg from '../../../images/website/shield.png';

useHead({
    title: 'تسجيل الدخول - Pulse',
});

const router = useRouter();
const toast = useToast();
const loading = ref(false);
const showPassword = ref(false);

const formData = reactive({
    email: '',
    password: '',
    remember: false,
});

const errors = reactive({
    email: '',
    password: '',
});


const resetErrors = () => {
    errors.email = '';
    errors.password = '';
};

const handleLogin = async () => {
    resetErrors();
    loading.value = true;

    try {
        const response = await axios.post('/user/login', formData);
        toast.success('تم تسجيل الدخول بنجاح!');

        // Reload page to update auth state
        setTimeout(() => {
            window.location.href = '/profile';
        }, 500);
    } catch (error: any) {
        if (error.response?.data?.errors) {
            Object.keys(error.response.data.errors).forEach(key => {
                if (errors.hasOwnProperty(key)) {
                    errors[key] = Array.isArray(error.response.data.errors[key])
                        ? error.response.data.errors[key][0]
                        : error.response.data.errors[key];
                }
            });
        } else {
            toast.error('فشل تسجيل الدخول. يرجى التحقق من بيانات الدخول.');
        }
    } finally {
        loading.value = false;
    }
};
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
