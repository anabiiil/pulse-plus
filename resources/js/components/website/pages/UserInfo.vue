<template>
    <div class="user-info-page">
        <!-- Navigation -->
        <Navigation />

        <!-- User Info Section -->
        <div class="min-h-screen bg-gray-100 py-10">
            <div class="max-w-4xl mx-auto px-4">
                <!-- Loading State -->
                <div v-if="loading" class="flex items-center justify-center py-20">
                    <div class="text-center">
                        <i class="pi pi-spin pi-spinner text-4xl text-[#1BB2B1] mb-4"></i>
                        <p class="text-gray-600 font-semibold">{{ t.userInfo.loading }}</p>
                    </div>
                </div>

                <!-- Error State -->
                <div v-else-if="error" class="bg-white rounded-3xl shadow-xl p-10 text-center">
                    <i class="pi pi-exclamation-triangle text-6xl text-red-500 mb-4"></i>
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ t.userInfo.error }}</h2>
                    <p class="text-gray-600 mb-6">{{ errorMessage }}</p>
                    <router-link :to="homePath" class="bg-[#1BB2B1] text-white px-8 py-3 rounded-[30px] inline-block hover:bg-[#14a89e] transition duration-150 font-semibold">
                        {{ t.userInfo.backToHome }}
                    </router-link>
                </div>

                <!-- User Info Display -->
                <div v-else-if="user" class="space-y-6">
                    <!-- Header Card -->
                    <div class="bg-white rounded-3xl shadow-xl p-8">
                        <div class="flex flex-col md:flex-row items-center gap-6">
                            <!-- Profile Image -->
                            <div class="flex-shrink-0">
                                <img
                                    :src="user.profile_image_url || defaultAvatar"
                                    :alt="user.name"
                                    class="w-32 h-32 rounded-full object-cover border-4 border-[#1BB2B1] shadow-lg"
                                >
                            </div>

                            <!-- User Basic Info -->
                            <div class="flex-1 text-center md:text-right">
                                <h1 class="text-3xl font-bold text-[#123057] mb-2">{{ user.name }}</h1>
                                <div class="space-y-2 text-gray-600">
                                    <p v-if="user.email" class="flex items-center justify-center md:justify-start gap-2">
                                        <i class="pi pi-envelope text-[#1BB2B1]"></i>
                                        <span class="[direction:ltr]">{{ user.email }}</span>
                                    </p>
                                    <p v-if="user.phone" class="flex items-center justify-center md:justify-start gap-2">
                                        <i class="pi pi-phone text-[#1BB2B1]"></i>
                                        <span class="[direction:ltr]">{{ user.phone }}</span>
                                    </p>
                                    <p v-if="user.country" class="flex items-center justify-center md:justify-start gap-2">
                                        <i class="pi pi-map-marker text-[#1BB2B1]"></i>
                                        <span>{{ user.country.name }}</span>
                                    </p>
                                </div>
                            </div>

                            <!-- QR Code -->
                            <div v-if="user.qr_code_url" class="flex-shrink-0">
                                <img
                                    :src="user.qr_code_url"
                                    alt="QR Code"
                                    class="w-32 h-32 border-2 border-gray-200 rounded-lg"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Personal Information Card -->
                    <div class="bg-white rounded-3xl shadow-xl p-8">
                        <h2 class="text-2xl font-bold text-[#123057] mb-6 flex items-center gap-2">
                            <i class="pi pi-user text-[#1BB2B1]"></i>
                            {{ t.userInfo.personalInfo }}
                        </h2>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div v-if="user.birthdate" class="p-4 bg-gray-50 rounded-xl">
                                <p class="text-sm text-gray-500 mb-1">{{ t.userInfo.birthdate }}</p>
                                <p class="font-semibold text-gray-800">{{ formatDate(user.birthdate) }}</p>
                            </div>
                            <div v-if="user.gender" class="p-4 bg-gray-50 rounded-xl">
                                <p class="text-sm text-gray-500 mb-1">{{ t.userInfo.gender }}</p>
                                <p class="font-semibold text-gray-800">{{ getGenderLabel(user.gender) }}</p>
                            </div>
                            <div v-if="user.marital_status" class="p-4 bg-gray-50 rounded-xl">
                                <p class="text-sm text-gray-500 mb-1">{{ t.userInfo.maritalStatus }}</p>
                                <p class="font-semibold text-gray-800">{{ getMaritalStatusLabel(user.marital_status) }}</p>
                            </div>
                            <div v-if="user.address" class="p-4 bg-gray-50 rounded-xl">
                                <p class="text-sm text-gray-500 mb-1">{{ t.userInfo.address }}</p>
                                <p class="font-semibold text-gray-800">{{ user.address }}</p>
                            </div>
                            <div v-if="user.emergency_phone" class="p-4 bg-gray-50 rounded-xl md:col-span-2">
                                <p class="text-sm text-gray-500 mb-1">{{ t.userInfo.emergencyPhone }}</p>
                                <p class="font-semibold text-gray-800 [direction:ltr]">{{ user.emergency_phone }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Medical Information Card -->
                    <div v-if="user.medical_info" class="bg-white rounded-3xl shadow-xl p-8">
                        <h2 class="text-2xl font-bold text-[#123057] mb-6 flex items-center gap-2">
                            <i class="pi pi-heart text-[#1BB2B1]"></i>
                            {{ t.userInfo.medicalInfo }}
                        </h2>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div v-if="user.medical_info.blood_type" class="p-4 bg-red-50 rounded-xl border-2 border-red-200">
                                <p class="text-sm text-red-600 mb-1 font-semibold">{{ t.userInfo.bloodType }}</p>
                                <p class="font-bold text-red-700 text-xl">{{ user.medical_info.blood_type }}</p>
                            </div>
                            <div v-if="user.medical_info.allergies" class="p-4 bg-yellow-50 rounded-xl border-2 border-yellow-200">
                                <p class="text-sm text-yellow-600 mb-1 font-semibold">{{ t.userInfo.allergies }}</p>
                                <p class="font-semibold text-yellow-700">{{ user.medical_info.allergies }}</p>
                            </div>
                            <div v-if="user.medical_info.medications" class="p-4 bg-blue-50 rounded-xl border-2 border-blue-200 md:col-span-2">
                                <p class="text-sm text-blue-600 mb-1 font-semibold">{{ t.userInfo.medications }}</p>
                                <p class="font-semibold text-blue-700">{{ user.medical_info.medications }}</p>
                            </div>
                            <div v-if="user.medical_info.medical_notes" class="p-4 bg-purple-50 rounded-xl border-2 border-purple-200 md:col-span-2">
                                <p class="text-sm text-purple-600 mb-1 font-semibold">{{ t.userInfo.medicalNotes }}</p>
                                <p class="font-semibold text-purple-700">{{ user.medical_info.medical_notes }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Diseases Card -->
                    <div v-if="user.diseases && user.diseases.length > 0" class="bg-white rounded-3xl shadow-xl p-8">
                        <h2 class="text-2xl font-bold text-[#123057] mb-6 flex items-center gap-2">
                            <i class="pi pi-info-circle text-[#1BB2B1]"></i>
                            {{ t.userInfo.diseases }}
                        </h2>
                        <div class="flex flex-wrap gap-3">
                            <span
                                v-for="disease in user.diseases"
                                :key="disease.id"
                                class="px-4 py-2 bg-orange-100 text-orange-700 rounded-full font-semibold border-2 border-orange-300"
                            >
                                {{ disease.name }}
                            </span>
                        </div>
                    </div>

                    <!-- Emergency Contact Notice -->
                    <div class="bg-red-50 border-2 border-red-300 rounded-3xl p-6 text-center">
                        <i class="pi pi-exclamation-circle text-red-600 text-3xl mb-3"></i>
                        <p class="text-red-700 font-bold text-lg">{{ t.userInfo.emergencyNotice }}</p>
                        <p v-if="user.emergency_phone" class="text-red-600 mt-2 [direction:ltr] text-xl font-bold">
                            {{ user.emergency_phone }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <Footer />
    </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useHead } from '@vueuse/head';
import { useWebsiteStore } from '../../../stores/websiteStore';
import { useToast } from 'vue-toastification';
import axios from 'axios';

// Import layout components
import Navigation from '../Navigation.vue';
import Footer from '../Footer.vue';

const router = useRouter();
const route = useRoute();
const websiteStore = useWebsiteStore();
const toast = useToast();

// Get translations
const t = computed(() => websiteStore.t);
const currentLocale = computed(() => websiteStore.locale || 'ar');
const homePath = computed(() => currentLocale.value === 'en' ? '/en' : '/ar');

// Default avatar
const defaultAvatar = 'https://via.placeholder.com/150/1BB2B1/FFFFFF?text=User';

useHead({
    title: computed(() => `${t.value.userInfo?.title || 'User Information'} - Pulse`),
});

// State
const user = ref<any>(null);
const loading = ref(true);
const error = ref(false);
const errorMessage = ref('');

// Helper functions
const formatDate = (date: string) => {
    if (!date) return '';
    return new Date(date).toLocaleDateString(currentLocale.value === 'ar' ? 'ar-EG' : 'en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
};

const getGenderLabel = (gender: string) => {
    const labels: any = {
        male: currentLocale.value === 'ar' ? 'ذكر' : 'Male',
        female: currentLocale.value === 'ar' ? 'أنثى' : 'Female'
    };
    return labels[gender] || gender;
};

const getMaritalStatusLabel = (status: string) => {
    const labels: any = {
        single: currentLocale.value === 'ar' ? 'أعزب' : 'Single',
        married: currentLocale.value === 'ar' ? 'متزوج' : 'Married',
        divorced: currentLocale.value === 'ar' ? 'مطلق' : 'Divorced',
        widowed: currentLocale.value === 'ar' ? 'أرمل' : 'Widowed'
    };
    return labels[status] || status;
};

// Fetch user information
const fetchUserInfo = async (uuid: string) => {
    loading.value = true;
    error.value = false;

    try {
        const currentLang = websiteStore.locale || 'ar';
        const response = await axios.get(`/api/website/user/info/${uuid}`, {
            headers: {
                'Accept-Language': currentLang
            }
        });

        if (response.data.success) {
            user.value = response.data.data;
        } else {
            error.value = true;
            errorMessage.value = response.data.message || t.value.userInfo.userNotFound;
        }
    } catch (err: any) {
        error.value = true;
        if (err.response?.status === 404) {
            errorMessage.value = err.response.data.message || t.value.userInfo.userNotFound;
        } else {
            errorMessage.value = t.value.userInfo.errorLoading;
        }
        console.error('Error fetching user info:', err);
    } finally {
        loading.value = false;
    }
};

onMounted(() => {
    // Initialize websiteStore and set router
    websiteStore.setRouter(router);

    // Get UUID from route params
    const uuid = route.params.uuid as string;
    if (uuid) {
        fetchUserInfo(uuid);
    } else {
        error.value = true;
        errorMessage.value = t.value.userInfo.invalidLink;
        loading.value = false;
    }
});
</script>

<style scoped>
.user-info-page {
    min-height: 100vh;
}
</style>

