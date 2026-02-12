<template>
    <div class="w-full max-w-sm bg-white rounded-2xl shadow-xl p-6">
        <form @submit.prevent="handleSubmit">
            <!-- Email Field -->
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

            <!-- Password Field -->
            <div class="mb-2 text-right">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    كلمة المرور
                </label>
                <div class="relative">
                    <i class="pi pi-lock absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
                    <input
                        v-model="formData.password"
                        :type="showPassword ? 'text' : 'password'"
                        class="focus-visible:outline-none focus-visible:ring-0 focus:ring-0 focus:border-transparent bg-gray-50 border-0 transition duration-300 ease-in-out hover:shadow-2xl cursor-pointer shadow-xl font-semibold rounded-[20px] w-full p-4 my-2 pr-12 pl-12"
                        placeholder="*********"
                        required
                    />
                    <button
                        type="button"
                        @click="showPassword = !showPassword"
                        class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700"
                    >
                        <i :class="showPassword ? 'pi pi-eye' : 'pi pi-eye-slash'"></i>
                    </button>
                    <p v-if="errors.password" class="text-red-500 text-sm mt-1 text-right">{{ errors.password }}</p>
                </div>
            </div>

            <!-- Forgot Password Link -->
            <div class="text-center mb-4">
                <a href="#" class="text-sm mb-2 text-teal-600 hover:underline">
                    نسيت كلمة المرور؟
                </a>
            </div>

            <!-- Submit Button -->
            <button
                type="submit"
                :disabled="loading"
                class="px-15 flex items-center justify-center mx-auto gap-2 bg-[#00A5AA] hover:bg-teal-700 text-white py-3 rounded-2xl font-medium transition disabled:opacity-50 disabled:cursor-not-allowed"
            >
                <svg v-if="!loading" width="18" height="21" viewBox="0 0 18 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M3.375 17.39L9 20.64V20.645L14.625 17.395C15.6498 16.8012 16.5009 15.9489 17.0931 14.9232C17.6854 13.8975 17.9981 12.7344 18 11.55V3.375C18 2.81 17.62 2.31 17.075 2.165L9 0L0.925 2.16C0.38 2.31 0 2.805 0 3.37V11.545C0.00193546 12.7294 0.31465 13.8925 0.906899 14.9182C1.49915 15.9439 2.35019 16.7962 3.375 17.39ZM1.5 11.545V3.56L9 1.55L16.5 3.56V11.545C16.4987 12.4661 16.2556 13.3707 15.7949 14.1683C15.3342 14.9659 14.6722 15.6286 13.875 16.09L9 18.905L4.125 16.09C3.32782 15.6286 2.66578 14.9659 2.20511 14.1683C1.74444 13.3707 1.5013 12.4661 1.5 11.545ZM6.866 12.2C7.111 12.445 7.431 12.565 7.751 12.565C8.071 12.565 8.391 12.445 8.636 12.2L13.78 7.055L12.72 5.995L7.75 10.965L5.78 8.995L4.72 10.055L6.865 12.2H6.866Z" fill="white"/>
                </svg>
                <span v-if="loading" class="inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                تسجيل الدخول
            </button>
        </form>
    </div>
</template>

<script setup lang="ts">
import { ref, reactive, computed } from 'vue';
import { useRouter } from 'vue-router';
import { useToast } from 'vue-toastification';
import { useWebsiteStore } from '../../../stores/websiteStore';
import { useAuth } from '../../../composables/useAuth';

const websiteStore = useWebsiteStore();
const router = useRouter();
const toast = useToast();
const { login, loading: authLoading } = useAuth();

const showPassword = ref(false);

const t = computed(() => websiteStore.t);
const isRTL = computed(() => websiteStore.isRTL);
const loading = computed(() => authLoading.value);

const formData = reactive({
    email: '',
    password: '',
    remember: false,
});

const errors = reactive<{
    email: string;
    password: string;
    [key: string]: string;
}>({
    email: '',
    password: '',
});

const resetErrors = () => {
    errors.email = '';
    errors.password = '';
};

const handleSubmit = async () => {
    resetErrors();

    try {
        await login({
            email: formData.email,
            password: formData.password,
            remember: formData.remember,
        });

        toast.success('تم تسجيل الدخول بنجاح');

        // Redirect to profile after successful login
        setTimeout(() => {
            const currentLocale = websiteStore.locale || 'ar';
            const profilePath = currentLocale === 'en' ? '/en/profile' : '/profile';
            router.push(profilePath);
        }, 500);
    } catch (error: any) {
        if (error.response?.status === 422) {
            // Validation errors
            const responseErrors = error.response.data.errors || {};
            Object.keys(responseErrors).forEach(key => {
                if (key in errors) {
                    errors[key] = Array.isArray(responseErrors[key])
                        ? responseErrors[key][0]
                        : responseErrors[key];
                }
            });
        } else {
            toast.error('فشل تسجيل الدخول. يرجى المحاولة مرة أخرى');
        }
    }
};
</script>

<style scoped>
/* Add any form-specific styles here */
</style>


