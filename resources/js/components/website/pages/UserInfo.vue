<template>
    <div class="user-info-page">
        <!-- Loading Screen -->
        <div
            v-if="loading"
            class="fixed inset-0 z-50 flex items-center justify-center bg-[#123057] transition-opacity duration-700 ease-out"
        >
            <div class="relative w-24 h-24">
                <div class="absolute inset-0 rounded-full border-4 border-white/30"></div>
                <div class="absolute inset-0 rounded-full border-4 border-[#FF6760] border-t-transparent animate-spin"></div>
                <div class="absolute inset-6 rounded-full bg-white"></div>
            </div>
        </div>

        <template v-else>
            <!-- Emergency Header -->
            <nav class="w-full p-10 bg-[#FF6760] text-center">
                <div class="flex flex-col items-center gap-4">
                    <i class="pi pi-bell text-[44px] text-white font-semibold"></i>
                    <p class="text-white text-[32px] font-bold">{{ t.userInfo.emergencyProfile }}</p>
                    <div class="flex gap-4">
                        <button @click="toggleLanguage" class="flex bg-white items-center justify-center w-[50px] h-[50px] text-[18px] rounded-full shadow-xl font-bold text-[#FF6760]">
                            {{ currentLocale === 'ar' ? 'EN' : 'AR' }}
                        </button>
                    </div>
                </div>
            </nav>

            <!-- Error State -->
            <div v-if="error" class="bg-gray-50 min-h-screen py-10">
                <div class="max-w-4xl mx-auto px-4">
                    <div class="bg-white rounded-[48px] shadow-xl p-10 text-center">
                        <i class="pi pi-exclamation-triangle text-6xl text-[#FF6760] mb-4"></i>
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ t.userInfo.error }}</h2>
                        <p class="text-gray-600 mb-6">{{ errorMessage }}</p>
                        <router-link :to="homePath" class="bg-[#FF6760] text-white px-8 py-3 rounded-[30px] inline-block hover:bg-[#e55850] transition duration-150 font-semibold">
                            {{ t.userInfo.backToHome }}
                        </router-link>
                    </div>
                </div>
            </div>

            <!-- User Info Display -->
            <section v-else class="bg-gray-50 py-4 lg:py-7 px-3 lg:px-5">
                <div class="grid lg:grid-cols-3 grid-cols-1 lg:gap-7 gap-0">
                    <!-- Left Sidebar (Desktop Only) -->
                    <div class="hidden lg:block p-5">
                        <div class="bg-white rounded-[48px] flex flex-col items-center justify-center gap-2 shadow-2xl px-5 lg:px-12 py-8 my-5">
                            <!-- Profile Image -->
                        <div class="bg-[#FF6760] my-4 rounded-[28px] shadow-[inset_0_4px_4px_0_rgba(0,0,0,0.25)] w-20 h-20 overflow-hidden flex items-center justify-center">
                            <img
                                v-if="user.profile_image_url"
                                :src="user.profile_image_url"
                                :alt="user.name"
                                class="w-full h-full object-cover"
                            >
                            <i v-else class="pi pi-user font-bold text-5xl text-white"></i>
                        </div>

                        <!-- Blood Type -->
                        <div v-if="user.medical_info?.blood_type" class="bg-[#FF6760] rounded-[28px] p-2.5 my-4 w-full flex justify-center items-center font-bold text-[18px] text-white shadow-[inset_0_4px_4px_0_rgba(0,0,0,0.25)]">
                            <div class="bg-white p-4 rounded-[18px] shadow-[inset_0_4px_4px_0_#00000040] font-bold text-[18px] text-[#FF6760] mx-4">
                                {{ user.medical_info.blood_type }}
                            </div>
                            {{ t.userInfo.bloodType }}
                        </div>

                        <!-- Emergency Call Button -->
                        <a
                            v-if="user.emergency_phone && user.display_emergency"
                            :href="`tel:${user.emergency_phone}`"
                            class="bg-[#FF6760] rounded-[28px] my-4 py-2.5 w-full flex justify-center items-center font-bold text-[18px] text-white shadow-[inset_0_4px_4px_0_rgba(0,0,0,0.25)] hover:bg-[#e55850] transition duration-150"
                        >
                            <div class="bg-white p-4 py-3 rounded-[18px] shadow-[inset_0_4px_4px_0_#00000040] font-bold text-[22px] text-[#FF6760] mx-4">
                                <i class="pi pi-phone"></i>
                            </div>
                            {{ t.userInfo.callEmergency }}
                        </a>
                    </div>

                    <!-- Footer Text (Desktop) -->
                    <div class="hidden lg:block py-4 px-18 mt-4 text-center text-gray-400 font-semibold mb-30">
                        {{ t.userInfo.disclaimer }}
                    </div>
                    <div class="hidden lg:block py-4 px-18 mt-4 text-center text-gray-400 font-semibold border-t border-gray-300">
                        {{ t.footer.copyright }}
                    </div>
                </div>

                <!-- Right Content -->
                <div class="col-span-2 p-2 lg:p-5">
                    <!-- Mobile Profile Box -->
                    <div class="lg:hidden bg-white rounded-[48px] shadow-2xl px-5 py-8 mb-5">
                        <div class="flex flex-col items-center justify-center gap-4">
                            <!-- Profile Image -->
                            <div class="bg-[#FF6760] rounded-[28px] shadow-[inset_0_4px_4px_0_rgba(0,0,0,0.25)] w-16 h-16 overflow-hidden flex items-center justify-center">
                                <img
                                    v-if="user.profile_image_url"
                                    :src="user.profile_image_url"
                                    :alt="user.name"
                                    class="w-full h-full object-cover"
                                >
                                <i v-else class="pi pi-user font-bold text-4xl text-white"></i>
                            </div>

                            <!-- User Name -->
                            <h2 class="text-xl font-bold text-[#123057]">{{ user.name }}</h2>

                            <!-- Blood Type Badge -->
                            <div v-if="user.medical_info?.blood_type" class="flex items-center gap-2 bg-[#FF6760] rounded-full px-6 py-2 shadow-lg">
                                <div class="bg-white px-3 py-1 rounded-full font-bold text-[#FF6760]">
                                    {{ user.medical_info.blood_type }}
                                </div>
                                <span class="text-white font-semibold">{{ t.userInfo.bloodType }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Personal Information Card -->
                    <div class="bg-white rounded-[48px] shadow-2xl px-5 lg:px-10 py-5 my-5">
                        <div class="p-2 font-bold text-[#FF6760] text-2xl lg:text-[32px] mb-3">
                            {{ t.userInfo.personalInfo }}
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Full Name -->
                            <div class="col-span-2 my-2">
                                <p class="text-gray-500 text-sm mb-1">{{ t.userInfo.fullName }}</p>
                                <p class="font-semibold text-lg">{{ user.name }}</p>
                            </div>

                            <!-- Birthdate -->
                            <div v-if="user.birthdate" class="my-2 col-span-2 lg:col-span-1">
                                <p class="text-gray-500 text-sm mb-1">{{ t.userInfo.birthdate }}</p>
                                <p class="font-semibold">{{ formatDate(user.birthdate) }}</p>
                            </div>

                            <!-- Gender -->
                            <div v-if="user.gender" class="my-2 col-span-2 lg:col-span-1">
                                <p class="text-gray-500 text-sm mb-1">{{ t.userInfo.gender }}</p>
                                <p class="font-semibold">{{ getGenderLabel(user.gender) }}</p>
                            </div>

                            <!-- Phone -->
                            <div v-if="user.phone" class="my-2 col-span-2 lg:col-span-1">
                                <p class="text-gray-500 text-sm mb-1">{{ t.userInfo.phoneNumber }}</p>
                                <p class="font-semibold [direction:ltr]">{{ user.phone }}</p>
                            </div>

                            <!-- Address -->
                            <div v-if="user.address" class="my-2 col-span-2 lg:col-span-1">
                                <p class="text-gray-500 text-sm mb-1">{{ t.userInfo.address }}</p>
                                <p class="font-semibold">{{ user.address }}</p>
                            </div>

                            <!-- Email -->
                            <div v-if="user.email" class="col-span-2 my-2">
                                <p class="text-gray-500 text-sm mb-1">{{ t.userInfo.email }}</p>
                                <p class="font-semibold [direction:ltr]">{{ user.email }}</p>
                            </div>

                            <!-- Nationality -->
                            <div v-if="user.country" class="my-2 col-span-2 lg:col-span-1">
                                <p class="text-gray-500 text-sm mb-1">{{ t.userInfo.nationality }}</p>
                                <p class="font-semibold">{{ user.country.name }}</p>
                            </div>

                            <!-- Marital Status -->
                            <div v-if="user.marital_status" class="my-2 col-span-2 lg:col-span-1">
                                <p class="text-gray-500 text-sm mb-1">{{ t.userInfo.maritalStatus }}</p>
                                <p class="font-semibold">{{ getMaritalStatusLabel(user.marital_status) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Medical Information Card -->
                    <div v-if="user.medical_info || (user.diseases && user.diseases.length > 0)" class="bg-white rounded-[48px] shadow-2xl px-5 lg:px-10 py-5 my-5">
                        <div class="p-2 font-bold text-[#FF6760] text-2xl lg:text-[32px] mb-3">
                            {{ t.userInfo.medicalInfo }}
                        </div>
                        <div class="grid grid-cols-2 gap-4">

                            <!-- Blood Type -->
                            <div v-if="user.medical_info?.blood_type" class="my-2 col-span-2 lg:col-span-1">
                                <p class="text-gray-500 text-sm mb-1">{{ t.userInfo.bloodType }}</p>
                                <p class="font-semibold text-[#FF6760] text-xl">{{ user.medical_info.blood_type }}</p>
                            </div>

                            <!-- Emergency Phone -->
                            <div v-if="user.emergency_phone" class="my-2 col-span-2 lg:col-span-1">
                                <p class="text-gray-500 text-sm mb-1">{{ t.userInfo.emergencyPhone }}</p>
                                <p class="font-semibold [direction:ltr]">{{ user.emergency_phone }}</p>
                            </div>

                            <!-- Chronic Diseases -->
                            <div v-if="user.diseases && user.diseases.length > 0" class="col-span-2 my-2">
                                <p class="text-gray-500 text-sm mb-1">{{ t.userInfo.chronicDiseasesAllergies }}</p>
                                <div class="flex flex-wrap gap-2 mt-2">
                                    <span
                                        v-for="disease in user.diseases"
                                        :key="disease.id"
                                        class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-sm font-semibold"
                                    >
                                        {{ disease.name }}
                                    </span>
                                </div>
                            </div>

                            <!-- Medical Notes -->
                            <div v-if="user.medical_info?.notes" class="my-2 col-span-2">
                                <p class="text-gray-500 text-sm mb-1">{{ t.userInfo.otherMedicalNotes }}</p>
                                <p class="font-semibold text-gray-800 leading-relaxed whitespace-pre-line">{{ user.medical_info.notes }}</p>
                            </div>

                        </div>
                    </div>

                    <!-- Emergency Call Button (Mobile) -->
                    <a
                        v-if="user.emergency_phone && user.display_emergency"
                        :href="`tel:${user.emergency_phone}`"
                        class="lg:hidden block bg-[#FF6760] py-5 px-6 text-2xl font-bold text-center text-white rounded-[28px] w-full shadow-2xl hover:bg-[#e55850] transition duration-150 my-5"
                    >
                        <div class="flex items-center justify-center gap-3">
                            <div class="bg-white p-3 rounded-full">
                                <i class="pi pi-phone text-[#FF6760] text-xl"></i>
                            </div>
                            <span>{{ t.userInfo.callEmergencyNumber }}</span>
                        </div>
                    </a>

                    <!-- Medical Archive Card -->
                    <div v-if="user.display_medical_archive && user.medical_files && user.medical_files.length > 0" class="bg-white rounded-[48px] shadow-2xl px-5 lg:px-10 py-5 my-5">
                        <div class="p-2 font-bold text-[#FF6760] text-2xl lg:text-[32px] mb-5">
                            {{ currentLocale === 'ar' ? 'الأرشيف الطبي' : 'Medical Archive' }}
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div
                                v-for="file in user.medical_files"
                                :key="file.id"
                                class="bg-gray-50 rounded-3xl p-5 shadow-md flex items-start gap-4"
                            >
                                <!-- File thumbnail or icon -->
                                <div class="shrink-0">
                                    <a v-if="file.file_url" :href="file.file_url" target="_blank">
                                        <img
                                            v-if="isImageUrl(file.file_url)"
                                            :src="file.file_url"
                                            :alt="file.title"
                                            class="w-14 h-14 rounded-2xl object-cover border border-gray-200"
                                        >
                                        <div v-else class="w-14 h-14 rounded-2xl bg-red-50 flex items-center justify-center border border-red-200">
                                            <i class="pi pi-file-pdf text-red-400 text-2xl"></i>
                                        </div>
                                    </a>
                                    <div v-else class="w-14 h-14 rounded-2xl bg-gray-200 flex items-center justify-center">
                                        <i class="pi pi-file text-gray-400 text-2xl"></i>
                                    </div>
                                </div>
                                <!-- Info -->
                                <div class="flex-1 min-w-0">
                                    <p class="font-bold text-[#123057] truncate">{{ file.title }}</p>
                                    <p v-if="file.doctor" class="text-sm text-gray-500 mt-0.5">
                                        <i class="pi pi-user me-1"></i>{{ file.doctor }}
                                    </p>
                                    <span class="inline-block mt-2 text-xs font-semibold px-3 py-1 rounded-full bg-teal-100 text-teal-700">
                                        {{ file.category }}
                                    </span>
                                </div>
                                <a v-if="file.file_url" :href="file.file_url" target="_blank"
                                    class="shrink-0 w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-teal-100 hover:text-teal-600 transition">
                                    <i class="pi pi-external-link text-sm"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Text (Mobile) -->
                    <div class="lg:hidden block py-4 px-18 mt-4 text-center text-gray-400 font-semibold mb-30">
                        {{ t.userInfo.disclaimer }}
                    </div>
                    <div class="lg:hidden block py-4 px-18 mt-4 text-center text-gray-400 font-semibold border-t border-gray-300">
                        {{ t.footer.copyright }}
                    </div>
                </div>
            </div>
            </section>
        </template>
    </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useHead } from '@vueuse/head';
import { useWebsiteStore } from '../../../stores/websiteStore';
import axios from 'axios';

const router = useRouter();
const route = useRoute();
const websiteStore = useWebsiteStore();

// Get translations
const t = computed(() => websiteStore.t);
const currentLocale = computed(() => websiteStore.locale || 'ar');
const homePath = computed(() => currentLocale.value === 'en' ? '/en' : '/ar');

useHead({
    title: computed(() => `${t.value.userInfo?.title || 'User Information'} - Pulse`),
});

// State
const user = ref<any>(null);
const loading = ref(true);
const error = ref(false);
const errorMessage = ref('');

// Toggle language
const toggleLanguage = () => {
    const uuid = route.params.uuid as string;
    const newLocale = currentLocale.value === 'ar' ? 'en' : 'ar';
    router.push(`/${newLocale}/user/info/${uuid}`);
};

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

const isImageUrl = (url: string): boolean => /\.(jpg|jpeg|png|gif|webp)(\?|$)/i.test(url);

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

