<template>
    <div class="contact-page">
        <!-- Navigation -->
        <Navigation />

        <!-- Contact Section -->
        <div class="p-10 bg-gray-100">
            <!-- Header -->
            <div class="p-10 text-center">
                <h2 class="text-4xl font-bold mb-6 text-[#123057]">
                    {{ t.contact.title }}
                </h2>
                <p class="text-gray-500 font-bold">{{ t.contact.subtitle }}</p>
            </div>

            <!-- Main Content Grid -->
            <div class="mx-auto grid lg:grid-cols-3 grid-cols-1 gap-12 px-4">
                <!-- Left Sidebar - Contact Info Cards -->
                <div>
                    <div class="mx-auto space-y-4">
                        <!-- Contact Info Card -->
                        <div class="bg-white p-10 rounded-[24px] space-y-3 shadow-[0_12px_30px_-18px_rgba(0,0,0,0.25)]">
                            <!-- Email -->
                            <div class="flex items-center gap-3 bg-[#F6F7F9] rounded-[14px] px-4 py-3">
                                <div class="p-3 rounded-xl shadow-[inset_0px_4px_4px_0px_rgba(0,0,0,0.25)] bg-[#1BB2B1] flex items-center justify-center">
                                    <i class="pi pi-envelope text-white text-[20px]"></i>
                                </div>
                                <span class="flex flex-col gap-2">
                                    <p class="text-gray-500 text-[13px]">{{ t.contact.info.email }}</p>
                                    <p class="[direction:ltr]">{{ contactInfo.email }}</p>
                                </span>
                            </div>

                            <!-- Phone -->
                            <div class="flex items-center gap-3 bg-[#F6F7F9] rounded-[14px] px-4 py-3">
                                <div class="p-3 rounded-xl shadow-[inset_0px_4px_4px_0px_rgba(0,0,0,0.25)] bg-[#1BB2B1] flex items-center justify-center">
                                    <i class="pi pi-phone text-white text-[20px]"></i>
                                </div>
                                <span class="flex flex-col gap-2">
                                    <p class="text-[13px] text-gray-500">{{ t.contact.info.phone }}</p>
                                    <p class="[direction:ltr]">{{ contactInfo.phone }}</p>
                                </span>
                            </div>

                            <!-- Location -->
                            <div class="flex items-center gap-3 bg-[#F6F7F9] rounded-[14px] px-4 py-3">
                                <div class="p-3 rounded-xl shadow-[inset_0px_4px_4px_0px_rgba(0,0,0,0.25)] bg-[#1BB2B1] flex items-center justify-center">
                                    <i class="pi pi-map-marker text-white text-[20px]"></i>
                                </div>
                                <span class="flex flex-col gap-2">
                                    <p class="text-[13px] text-gray-500">{{ t.contact.info.location }}</p>
                                    <p>{{ contactInfo.address }}</p>
                                </span>
                            </div>
                        </div>

                        <!-- Premium Service Card -->
                        <div class="bg-[#0C2A44] rounded-[22px] p-5 text-white shadow-[0_18px_40px_-20px_rgba(12,42,68,0.9)]">
                            <h3 class="text-[15px] font-semibold mb-2">
                                {{ t.contact.premiumService?.title || 'خدمة مميزة' }}
                            </h3>
                            <p class="text-[13px] leading-relaxed text-gray-200 mb-4">
                                {{ t.contact.premiumService?.description || 'احصل على استشارة مجانية وتواصل مع فريقنا لمساعدتك في اختيار الحل الأنسب لك' }}
                            </p>
                            <button class="w-full py-3 rounded-xl bg-[#19C5A3] text-center text-white text-[14px] font-semibold hover:bg-[#14b092] transition duration-150">
                                {{ t.contact.premiumService?.button || 'احجز استشارة مجانية' }}
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Right Side - Contact Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white p-10 rounded-[48px] shadow-xl">
                        <div class="text-2xl font-bold p-10 mb-8 text-[#123057]">
                            {{ t.contact.form.sendMessage || 'أرسل لنا رسالة' }}
                        </div>

                        <form @submit.prevent="submitForm" class="grid gap-7 grid-cols-1 lg:grid-cols-2">
                            <!-- Name Field -->
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">{{ t.contact.form.name }}</label>
                                <input
                                    v-model="form.name"
                                    type="text"
                                    :placeholder="t.contact.form.namePlaceholder"
                                    class="focus-visible:outline-none focus-visible:ring-0 focus:ring-0 focus:border-transparent bg-gray-50 border-0 transition-shadow duration-300 ease-in-out hover:shadow-2xl cursor-pointer shadow-xl font-semibold rounded-[30px] w-full p-4 my-2"
                                    :class="{ 'border-2 border-red-500': errors.name }"
                                />
                                <p v-if="errors.name" class="text-red-500 text-sm mt-1">{{ errors.name[0] }}</p>
                            </div>

                            <!-- Email Field -->
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">{{ t.contact.form.email }}</label>
                                <input
                                    v-model="form.email"
                                    type="email"
                                    :placeholder="t.contact.form.emailPlaceholder"
                                    class="focus-visible:outline-none focus-visible:ring-0 focus:ring-0 focus:border-transparent bg-gray-50 border-0 transition-shadow duration-300 ease-in-out hover:shadow-2xl cursor-pointer shadow-xl font-semibold rounded-[30px] w-full p-4 my-2"
                                    :class="{ 'border-2 border-red-500': errors.email }"
                                />
                                <p v-if="errors.email" class="text-red-500 text-sm mt-1">{{ errors.email[0] }}</p>
                            </div>

                            <!-- Subject Field -->
                            <div class="lg:col-span-2">
                                <label class="block text-gray-700 font-semibold mb-2">{{ t.contact.form.subject }}</label>
                                <input
                                    v-model="form.subject"
                                    type="text"
                                    :placeholder="t.contact.form.subjectPlaceholder"
                                    class="focus-visible:outline-none focus-visible:ring-0 focus:ring-0 focus:border-transparent bg-gray-50 border-0 transition-shadow duration-300 ease-in-out hover:shadow-2xl cursor-pointer shadow-xl font-semibold rounded-[30px] w-full p-4 my-2"
                                    :class="{ 'border-2 border-red-500': errors.subject }"
                                />
                                <p v-if="errors.subject" class="text-red-500 text-sm mt-1">{{ errors.subject[0] }}</p>
                            </div>

                            <!-- Message Field -->
                            <div class="lg:col-span-2">
                                <label class="block text-gray-700 font-semibold mb-2">{{ t.contact.form.message }}</label>
                                <textarea
                                    v-model="form.message"
                                    :placeholder="t.contact.form.messagePlaceholder"
                                    class="focus-visible:outline-none focus-visible:ring-0 focus:ring-0 focus:border-transparent bg-gray-50 border-0 transition-shadow duration-300 ease-in-out hover:shadow-2xl cursor-pointer shadow-xl font-semibold rounded-[30px] w-full p-4 my-2 min-h-[150px] resize-none"
                                    :class="{ 'border-2 border-red-500': errors.message }"
                                ></textarea>
                                <p v-if="errors.message" class="text-red-500 text-sm mt-1">{{ errors.message[0] }}</p>
                            </div>

                            <!-- Submit Button -->
                            <div class="lg:col-span-2 p-2 flex items-center justify-center">
                                <button
                                    type="submit"
                                    :disabled="submitting"
                                    class="px-20 py-3 rounded-xl bg-[#00A5AA] text-white flex items-center hover:bg-[#008a8e] transition duration-150 disabled:opacity-50 disabled:cursor-not-allowed font-semibold"
                                >
                                    <i class="pi pi-send mx-2"></i>
                                    <span v-if="!submitting">{{ t.contact.form.submit }}</span>
                                    <span v-else>{{ t.contact.form.sending }}</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <Footer />
    </div>
</template>

<script setup lang="ts">
import { ref, reactive, computed, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useHead } from '@vueuse/head';
import { useWebsiteStore } from '../../../stores/websiteStore';
import { useToast } from 'vue-toastification';
import axios from 'axios';

// Import layout components
import Navigation from '../Navigation.vue';
import Footer from '../Footer.vue';

const router = useRouter();
const websiteStore = useWebsiteStore();
const toast = useToast();

// Get translations
const t = computed(() => websiteStore.t);

useHead({
    title: computed(() => `${t.value.contact?.title || 'Contact Us'} - Pulse`),
});

// Form state
const form = reactive({
    name: '',
    email: '',
    subject: '',
    message: '',
});

const errors = ref<any>({});
const submitting = ref(false);
const contactInfo = ref({
    phone: '01555227756 / 01550111555',
    email: 'info@pulse-plus.com',
    address: websiteStore.locale === 'ar' ? 'القاهرة، جمهورية مصر العربية' : 'Cairo, Arab Republic of Egypt'
});
const loadingInfo = ref(false);

// Fetch contact information from API
const fetchContactInfo = async () => {
    loadingInfo.value = true;
    try {
        const currentLang = websiteStore.locale || 'ar';
        const response = await axios.get('/api/website/contact-info', {
            headers: {
                'Accept-Language': currentLang
            }
        });

        if (response.data.success && response.data.data) {
            contactInfo.value = response.data.data;
        }
    } catch (error) {
        console.error('Failed to load contact info:', error);
        // Keep default values on error
    } finally {
        loadingInfo.value = false;
    }
};

// Submit form
const submitForm = async () => {
    if (submitting.value) return;

    submitting.value = true;
    errors.value = {};

    try {
        // Send language header to backend
        const currentLang = websiteStore.locale || 'ar';
        const response = await axios.post('/api/website/contact-messages', form, {
            headers: {
                'Accept-Language': currentLang
            }
        });

        if (response.data.success) {
            toast.success(response.data.message || t.value.contact.messages.success);

            // Reset form
            form.name = '';
            form.email = '';
            form.subject = '';
            form.message = '';
        }
    } catch (error: any) {
        if (error.response?.status === 422) {
            // Validation errors
            errors.value = error.response.data.errors || {};

            // Display first error or use generic message
            const firstErrorField = Object.keys(errors.value)[0];
            const firstErrorMessage = errors.value[firstErrorField]
                ? (Array.isArray(errors.value[firstErrorField])
                    ? errors.value[firstErrorField][0]
                    : errors.value[firstErrorField])
                : error.response.data.message;

            toast.error(firstErrorMessage || t.value.contact.messages.validationError);
        } else {
            toast.error(error.response?.data?.message || t.value.contact.messages.error);
        }
    } finally {
        submitting.value = false;
    }
};

onMounted(() => {
    // Initialize websiteStore and set router
    websiteStore.setRouter(router);

    // Fetch dynamic contact information
    fetchContactInfo();
});
</script>

<style scoped>
.contact-page {
    min-height: 100vh;
}
</style>

