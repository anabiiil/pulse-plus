<template>
    <div class="profile-page">
        <!-- Navigation -->
        <Navigation />

        <!-- Profile Content -->
        <section class="lg:px-10 px-4 py-5 bg-gray-100 min-h-screen">
            <div class="grid lg:grid-cols-3 grid-cols-1 lg:gap-10 gap-0">
                <!-- Sidebar -->
                <div>
                    <!-- Profile Completion Card (Desktop) -->
                    <div class="hidden lg:block bg-white rounded-[48px] shadow-xl p-8">
                    <div class="mb-6">
                        <div class="flex justify-between text-sm text-teal-600 mb-2">
                            <span class="font-medium">{{ t.profile.profileCompletion }}</span>
                            <span>{{ profileCompletion }}%</span>
                        </div>
                        <div class="w-full h-5 shadow-[inset_0_4px_4px_0_#00000040] flex items-center bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-4 bg-[#1BB2B1] rounded-full transition-all duration-300" :style="{ width: profileCompletion + '%' }"></div>
                        </div>
                    </div>

                    <!-- Menu Items -->
                    <div class="space-y-4">
                        <!-- Personal Info Tab -->
                        <div
                            @click="activeTab = 'personal'"
                            :class="activeTab === 'personal' ? 'bg-teal-500 text-white shadow-xl' : 'bg-gray-100 text-[#123057]'"
                            class="cursor-pointer hover:scale-102 transition-transform duration-300 ease-in-out rounded-3xl px-7 py-6 flex items-center justify-between shadow-md"
                        >
                            <div class="flex items-center gap-3">
                                <div :class="activeTab === 'personal' ? 'bg-white' : 'bg-white shadow-2xl'" class="p-5 rounded-xl flex items-center justify-center">
                                    <i :class="activeTab === 'personal' ? 'text-teal-500' : 'text-teal-500'" class="pi pi-user text-[22px]"></i>
                                </div>
                                <div>
                                    <p class="font-semibold">{{ t.profile.personalInfo.title }}</p>
                                    <p class="text-sm opacity-90">{{ t.profile.personalInfo.subtitle }}</p>
                                </div>
                            </div>
                            <div class="text-xl text-gray-400"><i :class="isRTL ? 'pi-angle-left' : 'pi-angle-right'" class="pi"></i></div>
                        </div>

                        <!-- Medical Data Tab - Commented for future use -->
                        <!--
                        <div
                            @click="activeTab = 'medical'"
                            :class="activeTab === 'medical' ? 'bg-teal-500 text-white shadow-xl' : 'bg-gray-100 text-[#123057]'"
                            class="cursor-pointer hover:scale-102 transition-transform duration-300 ease-in-out rounded-3xl px-7 py-6 flex items-center justify-between shadow-md"
                        >
                            <div class="flex items-center gap-3">
                                <div :class="activeTab === 'medical' ? 'bg-white' : 'bg-white shadow-2xl'" class="p-5 rounded-xl flex items-center justify-center">
                                    <i :class="activeTab === 'medical' ? 'text-teal-500' : 'text-teal-500'" class="pi pi-heart text-[22px]"></i>
                                </div>
                                <div>
                                    <p class="font-semibold">البيانات الطبية</p>
                                    <p class="text-sm opacity-90">فصيلة الدم، الحساسية...</p>
                                </div>
                            </div>
                            <div class="text-xl text-gray-400"><i class="pi pi-angle-left"></i></div>
                        </div>
                        -->

                        <!-- Medical Archive Tab - Commented for future use -->
                        <!--
                        <div
                            @click="activeTab = 'archive'"
                            :class="activeTab === 'archive' ? 'bg-teal-500 text-white shadow-xl' : 'bg-gray-100 text-[#123057]'"
                            class="cursor-pointer hover:scale-102 transition-transform duration-300 ease-in-out rounded-3xl px-7 py-6 flex items-center justify-between shadow-md"
                        >
                            <div class="flex items-center gap-3">
                                <div :class="activeTab === 'archive' ? 'bg-white' : 'bg-white shadow-2xl'" class="p-5 rounded-xl flex items-center justify-center">
                                    <i :class="activeTab === 'archive' ? 'text-teal-500' : 'text-teal-500'" class="pi pi-file text-[22px]"></i>
                                </div>
                                <div>
                                    <p class="font-semibold">الأرشيف الطبي</p>
                                    <p class="text-sm opacity-90">الأشعة والتقارير والروشتات...</p>
                                </div>
                            </div>
                            <div class="text-xl text-gray-400"><i class="pi pi-angle-left"></i></div>
                        </div>
                        -->
                    </div>
                </div>

                <!-- Security Notice -->
                <div class="mt-8 py-20 my-4 bg-[#0E2A4F] text-white rounded-[48px] px-10 relative">
                    <div class="my-5">
                        <i class="pi pi-shield font-bold text-[35px]"></i>
                    </div>
                    <h3 class="font-semibold mb-2 text-[20px]">{{ t.profile.securityNotice.title }}</h3>
                    <p class="text-sm leading-relaxed text-white/80">
                        {{ t.profile.securityNotice.description }}
                    </p>
                </div>

                <!-- Profile Completion Card (Mobile) -->
                <div class="lg:hidden my-4 block bg-white rounded-[48px] shadow-xl p-8">
                    <div class="mb-6">
                        <div class="flex justify-between text-sm text-teal-600 mb-2">
                            <span class="font-medium">{{ t.profile.profileCompletion }}</span>
                            <span>{{ profileCompletion }}%</span>
                        </div>
                        <div class="w-full h-5 shadow-[inset_0_4px_4px_0_#00000040] flex items-center bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-4 bg-[#1BB2B1] rounded-full transition-all duration-300" :style="{ width: profileCompletion + '%' }"></div>
                        </div>
                    </div>
                </div>


            </div>

            <!-- Main Content -->
            <div class="col-span-2">
                <!-- Personal Information Tab -->
                <div v-show="activeTab === 'personal'" class="bg-white p-10 rounded-[48px] shadow-xl transform transition duration-500 hover:shadow-2xl">
                    <div class="mb-4">
                        <h3 class="text-2xl font-bold mb-2">{{ t.profile.form.whoAreYou }}</h3>
                        <p class="text-gray-600 text-[14px] font-semibold">
                            {{ t.profile.form.whoAreYouSubtitle }}
                        </p>
                    </div>

                    <!-- Profile Image Upload -->
                    <div class="bg-[#1BB2B1] shadow-[inset_0_4px_4px_0_#12305766] p-10 w-full rounded-3xl flex items-center justify-center mb-6">
                        <div class="flex flex-col items-center">
                            <div class="p-3 w-fit rounded-[32px] bg-white relative shadow-2xl cursor-pointer">
                                <img v-if="!profileImage" :src="userVectorImg" alt="User" class="rounded-2xl w-20 h-20 ">
                                <img v-else :src="profileImage" alt="Profile" class="rounded-2xl object-cover w-20 h-20 ">
                                <input @change="handleImageUpload" class="opacity-0 w-full h-full absolute top-0 left-0 cursor-pointer rounded-[32px]" type="file" accept="image/*">
                            </div>
                            <div class="text-center text-white mt-4">
                                <h3 class="font-bold text-xl">{{ t.profile.form.profileImage }}</h3>
                                <p>{{ t.profile.form.profileImageDesc }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Form -->
                    <form @submit.prevent="handleUpdate">
                        <div class="grid lg:grid-cols-2 grid-cols-1">
                            <!-- Full Name -->
                            <div class="p-2 text-[#123057] flex flex-col col-span-2 relative">
                                <label class="font-bold">{{ t.profile.form.fullName }}</label>
                                <div class="relative">
                                    <input
                                        v-model="formData.name"
                                        type="text"
                                        :placeholder="t.profile.form.fullNamePlaceholder"
                                        class="focus:ring-0 focus:border-transparent bg-gray-50 border-0 transition-shadow duration-300 ease-in-out hover:shadow-2xl cursor-pointer shadow-xl font-semibold rounded-[30px] w-full p-4 my-2 pr-12"
                                    >
                                    <i class="pi pi-user absolute top-1/2 right-5 text-gray-400 text-[18px] -translate-y-1/2"></i>
                                </div>
                                <p v-if="errors.name" class="text-red-500 text-sm mt-1">{{ errors.name }}</p>
                            </div>

                            <!-- Birth Date -->
                            <div class="p-2 text-[#123057] flex flex-col col-span-2 lg:col-span-1 relative">
                                <label class="font-bold">{{ t.profile.form.birthdate }}</label>
                                <div class="relative">
                                    <input
                                        v-model="formData.birthdate"
                                        type="date"
                                        class="focus:ring-0 focus:border-transparent bg-gray-50 border-0 shadow-xl transition-shadow duration-300 ease-in-out hover:shadow-2xl cursor-pointer font-semibold rounded-[30px] w-full p-4 my-2 pr-12"
                                    >
                                    <i class="pi pi-calendar absolute top-1/2 text-gray-400 right-5 text-[18px] -translate-y-1/2"></i>
                                </div>
                            </div>

                            <!-- Gender -->
                            <div class="p-2 text-[#123057] flex flex-col col-span-2 lg:col-span-1 relative">
                                <label class="font-bold">{{ t.profile.form.gender }}</label>
                                <div class="relative">
                                    <select
                                        v-model="formData.gender"
                                        class="focus:ring-0 focus:border-transparent bg-gray-50 border-0 shadow-xl transition-shadow duration-300 ease-in-out hover:shadow-2xl cursor-pointer font-semibold rounded-[30px] w-full p-4 my-2 pr-12"
                                    >
                                        <option value="male">{{ t.profile.form.male }}</option>
                                        <option value="female">{{ t.profile.form.female }}</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Email (Read-only) -->
                            <div class="p-2 text-[#123057] flex flex-col  col-span-2 lg:col-span-1  relative">
                                <label class="font-bold">{{ t.profile.form.email }}</label>
                                <div class="relative">
                                    <input
                                        v-model="formData.email"
                                        type="email"
                                        :placeholder="t.profile.form.emailPlaceholder"
                                        dir="ltr"
                                        readonly
                                        class="focus:ring-0 focus:border-transparent bg-gray-200 border-0 shadow-xl transition-shadow duration-300 ease-in-out cursor-not-allowed font-semibold rounded-[30px] w-full p-4 my-2 pr-12"
                                    >
                                    <i class="pi pi-envelope absolute top-1/2 text-gray-400 right-5 text-[18px] -translate-y-1/2"></i>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">{{ currentLocale === 'ar' ? 'لا يمكن تعديل البريد الإلكتروني' : 'Email address cannot be changed' }}</p>
                            </div>
                            <!-- Phone (Read-only) -->
                            <div class="p-2 text-[#123057] flex flex-col col-span-2 lg:col-span-1 relative">
                                <label class="font-bold">{{ t.profile.form.phone }}</label>
                                <div class="relative">
                                    <input
                                        v-model="formData.phone"
                                        type="text"
                                        :placeholder="t.profile.form.phonePlaceholder"
                                        dir="ltr"
                                        readonly
                                        class="focus:ring-0 focus:border-transparent bg-gray-200 border-0 shadow-xl transition-shadow duration-300 ease-in-out cursor-not-allowed font-semibold rounded-[30px] w-full p-4 my-2 pr-12"
                                    >
                                    <i class="pi pi-phone absolute top-1/2 text-gray-400 right-5 text-[18px] -translate-y-1/2"></i>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">{{ currentLocale === 'ar' ? 'لا يمكن تعديل رقم الهاتف' : 'Phone number cannot be changed' }}</p>
                            </div>



                            <!-- Emergency Phone -->
                            <div class="p-2 text-[#123057] flex flex-col col-span-2 lg:col-span-1 relative">
                                <label class="font-bold">{{ t.profile.form.emergencyPhone }}</label>
                                <div class="relative">
                                    <input
                                        v-model="formData.emergency_phone"
                                        type="text"
                                        :placeholder="t.profile.form.emergencyPhonePlaceholder"
                                        dir="ltr"
                                        class="focus:ring-0 focus:border-transparent bg-gray-50 border-0 shadow-xl transition-shadow duration-300 ease-in-out hover:shadow-2xl cursor-pointer font-semibold rounded-[30px] w-full p-4 my-2 pr-12"
                                    >
                                    <i class="pi pi-phone absolute top-1/2 text-gray-400 right-5 text-[18px] -translate-y-1/2"></i>
                                </div>
                            </div>

                            <!-- Display Emergency Toggle -->
                            <div class="p-2 text-[#123057] flex flex-col col-span-2 relative">
                                <div class="bg-gray-50 border-0 shadow-xl rounded-[30px] p-6 my-2">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <label class="font-bold text-lg cursor-pointer">{{ t.profile.form.displayEmergency }}</label>
                                            <p class="text-sm text-gray-600 mt-1">{{ t.profile.form.displayEmergencyDesc }}</p>
                                        </div>
                                        <div class="flex-shrink-0 ml-4">
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input
                                                    type="checkbox"
                                                    v-model="formData.display_emergency"
                                                    class="sr-only peer"
                                                >
                                                <div class="w-14 h-7 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-teal-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-teal-500"></div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- View Emergency Profile Link -->
                            <div v-if="authUser?.hash_url" class="p-2 text-[#123057] flex flex-col col-span-2 relative">
                                <div class="bg-[#FF6760] border-0 shadow-xl rounded-[30px] p-6 my-2">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1 text-white">
                                            <label class="font-bold text-lg">{{ t.profile.form.emergencyProfileLink }}</label>
                                            <p class="text-sm text-white/90 mt-1">{{ t.profile.form.emergencyProfileLinkDesc }}</p>
                                        </div>
                                        <div class="flex-shrink-0 ml-4">
                                            <a
                                                :href="`/user/info/${authUser.hash_url}`"
                                                target="_blank"
                                                class="inline-flex items-center gap-2 bg-white text-[#FF6760] font-bold px-6 py-3 rounded-full hover:bg-gray-100 transition duration-150 shadow-lg"
                                            >
                                                <i class="pi pi-external-link"></i>
                                                {{ t.profile.form.viewProfile }}
                                            </a>
                                        </div>
                                    </div>
                                    <div class="mt-4 pt-4 border-t border-white/20">
                                        <div class="flex items-center gap-2 text-white/90 text-sm">
                                            <i class="pi pi-link"></i>
                                            <code class="bg-white/20 px-3 py-1 rounded-lg text-xs break-all">{{ window.location.origin }}/user/info/{{ authUser.hash_url }}</code>
                                            <button
                                                @click="copyProfileLink"
                                                class="ml-auto bg-white/20 hover:bg-white/30 px-3 py-1 rounded-lg text-xs transition"
                                            >
                                                <i class="pi pi-copy"></i> {{ t.profile.form.copyLink }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <!-- Address -->
                            <div class="p-2 text-[#123057] flex flex-col col-span-2 lg:col-span-1 relative">
                                <label class="font-bold">{{ t.profile.form.address }}</label>
                                <div class="relative">
                                    <input
                                        v-model="formData.address"
                                        type="text"
                                        :placeholder="t.profile.form.addressPlaceholder"
                                        class="focus:ring-0 focus:border-transparent bg-gray-50 border-0 shadow-xl transition-shadow duration-300 ease-in-out hover:shadow-2xl cursor-pointer font-semibold rounded-[30px] w-full p-4 my-2 pr-12"
                                    >
                                    <i class="pi pi-map-marker absolute top-1/2 text-gray-400 right-5 text-[18px] -translate-y-1/2"></i>
                                </div>
                            </div>



                            <!-- Nationality -->
                            <div class="p-2 text-[#123057] flex flex-col col-span-2 lg:col-span-1 relative">
                                <label class="font-bold">{{ t.profile.form.nationality }}</label>
                                <div class="relative">
                                    <select
                                        v-model="formData.nationality_id"
                                        class="focus:ring-0 focus:border-transparent bg-gray-50 border-0 shadow-xl transition-shadow duration-300 ease-in-out hover:shadow-2xl cursor-pointer font-semibold rounded-[30px] w-full p-4 my-2 pr-12"
                                    >
                                        <option value="" disabled>{{ t.profile.form.selectNationality }}</option>
                                        <option
                                            v-for="nationality in nationalities"
                                            :key="nationality.id"
                                            :value="nationality.id"
                                        >
                                            {{ currentLocale === 'ar' ? nationality.name_ar : nationality.name_en }}
                                        </option>
                                    </select>
                                    <i class="pi pi-flag absolute top-1/2 text-gray-400 right-5 text-[18px] -translate-y-1/2 pointer-events-none"></i>
                                </div>
                            </div>

                            <!-- Marital Status -->
                            <div class="p-2 text-[#123057] flex flex-col col-span-2 lg:col-span-1 relative">
                                <label class="font-bold">{{ t.profile.form.maritalStatus }}</label>
                                <div class="relative">
                                    <select
                                        v-model="formData.marital_status"
                                        class="focus:ring-0 focus:border-transparent bg-gray-50 border-0 transition-shadow duration-300 ease-in-out hover:shadow-2xl cursor-pointer shadow-xl font-semibold rounded-[30px] w-full p-4 my-2 pr-12"
                                    >
                                        <option value="" disabled>{{ t.profile.form.selectMaritalStatus }}</option>
                                        <option
                                            v-for="status in maritalStatusOptions"
                                            :key="status.value"
                                            :value="status.value"
                                        >
                                            {{ currentLocale === 'ar' ? status.label_ar : status.label_en }}
                                        </option>
                                    </select>
                                    <i class="pi pi-users absolute top-1/2 text-gray-400 right-5 text-[18px] -translate-y-1/2 pointer-events-none"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex flex-col items-center justify-center">
                            <button
                                type="submit"
                                :disabled="updating"
                                class="py-3 px-20 border-0 rounded-xl bg-[#123057] text-white font-bold hover:bg-[#0e2540] transition duration-150 mt-6 disabled:opacity-50"
                            >
                                <span v-if="!updating">{{ t.profile.form.saveChanges }}</span>
                                <span v-else>{{ t.profile.form.saving }}</span>
                            </button>
                            <button
                                type="button"
                                @click="resetForm"
                                class="py-3 px-20 border-0 text-gray-400 mt-4 font-semibold"
                            >
                                {{ t.profile.form.cancelChanges }}
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Medical Data Tab - Commented for future use -->
                <!--
                <div v-show="activeTab === 'medical'" class="bg-white p-10 rounded-[48px] shadow-xl">
                    <h3 class="text-2xl font-bold mb-4">البيانات الطبية</h3>
                    <p class="text-gray-600">هذا القسم قيد التطوير...</p>
                </div>
                -->

                <!-- Medical Archive Tab - Commented for future use -->
                <!--
                <div v-show="activeTab === 'archive'" class="bg-white p-10 rounded-[48px] shadow-xl">
                    <h3 class="text-2xl font-bold mb-4">الأرشيف الطبي</h3>
                    <p class="text-gray-600">هذا القسم قيد التطوير...</p>
                </div>
                -->
            </div>

        </div>
    </section>

    <!-- Footer -->
    <Footer />
</div>
</template>

<script setup lang="ts">
import { ref, reactive, onMounted, computed } from 'vue';
import { useRouter } from 'vue-router';
import { useHead } from '@vueuse/head';
import { useAuth } from '../../../composables/useAuth';
import { useToast } from 'vue-toastification';
import { useWebsiteStore } from '../../../stores/websiteStore';
import axios from 'axios';
import userVectorImg from '../../../images/website/user-vector.png';

// Import layout components
import Navigation from '../Navigation.vue';
import Footer from '../Footer.vue';

const router = useRouter();
const { user: authUser, fetchUser } = useAuth();
const toast = useToast();
const websiteStore = useWebsiteStore();

// Get translations
const t = computed(() => websiteStore.t);
const currentLocale = computed(() => websiteStore.locale);
const isRTL = computed(() => websiteStore.isRTL);

useHead({
    title: computed(() => `${t.value.profile.title} - Pulse`),
});

// Active tab state
const activeTab = ref('personal');

// Profile image
const profileImage = ref<string | null>(null);
const profileImageFile = ref<File | null>(null);

// Loading states
const updating = ref(false);

// Options for selects
const nationalities = ref<Array<{id: number, name_ar: string, name_en: string}>>([]);
const maritalStatusOptions = ref<Array<{value: string, label_ar: string, label_en: string}>>([]);

// Form data
const formData = reactive({
    name: '',
    email: '', // Read-only, not sent in update
    phone: '', // Read-only, not sent in update
    emergency_phone: '',
    display_emergency: false,
    birthdate: '',
    gender: 'male',
    address: '',
    nationality_id: null as number | null,
    marital_status: '',
});

// Errors
const errors = reactive<Record<string, string>>({
    name: '',
    email: '',
    phone: '',
});

// Profile completion calculation
const profileCompletion = computed(() => {
    let completed = 0;
    const fields = ['name', 'email', 'phone', 'emergency_phone', 'birthdate', 'gender', 'address', 'nationality_id', 'marital_status'];

    fields.forEach(field => {
        if (formData[field as keyof typeof formData]) {
            completed++;
        }
    });

    if (profileImage.value) completed++;

    return Math.round((completed / (fields.length + 1)) * 100);
});

// Reset errors
const resetErrors = () => {
    errors.name = '';
    errors.email = '';
    errors.phone = '';
};

// Fetch nationalities from API
const fetchNationalities = async () => {
    try {
        const response = await axios.get('/api/website/nationalities');
        nationalities.value = response.data.data.nationalities || [];
    } catch (error) {
        console.error('Error fetching nationalities:', error);
    }
};

// Fetch marital status options from API
const fetchMaritalStatus = async () => {
    try {
        const response = await axios.get('/api/website/enums/marital-status');
        maritalStatusOptions.value = response.data.data.marital_status_options || [];
    } catch (error) {
        console.error('Error fetching marital status:', error);
    }
};

// Load user data
const loadUser = async () => {
    try {
        await fetchUser();
        if (authUser.value) {
            formData.name = authUser.value.name || '';
            formData.email = authUser.value.email || '';
            formData.phone = authUser.value.phone || '';
            formData.emergency_phone = authUser.value.emergency_phone || '';
            formData.display_emergency = authUser.value.display_emergency || false;
            formData.birthdate = authUser.value.birthdate || '';
            formData.gender = authUser.value.gender || 'male';
            formData.address = authUser.value.address || '';
            formData.nationality_id = authUser.value.country_id || null;
            formData.marital_status = authUser.value.marital_status || '';

            // Set profile image if exists
            if (authUser.value.profile_image_url) {
                profileImage.value = authUser.value.profile_image_url;
            }
        }
    } catch (error: any) {
        console.error('Error loading user:', error);

        // If 401 Unauthenticated, redirect to login
        if (error.response?.status === 401) {
            toast.error(currentLocale.value === 'ar' ? 'يجب تسجيل الدخول أولاً' : 'Please login first');
            // Redirect to login page
            window.location.href = `/${currentLocale.value === 'ar' ? 'ar' : 'en'}/login`;
        } else {
            toast.error(t.value.profile.messages.errorLoad);
        }
    }
};

// Handle image upload
const handleImageUpload = (event: Event) => {
    const target = event.target as HTMLInputElement;
    const file = target.files?.[0];

    if (file) {
        // Store the file for uploading
        profileImageFile.value = file;

        // Show preview
        const reader = new FileReader();
        reader.onload = (e) => {
            profileImage.value = e.target?.result as string;
        };
        reader.readAsDataURL(file);
    }
};

// Handle form update
const handleUpdate = async () => {
    resetErrors();
    updating.value = true;

    try {
        // Create FormData for multipart/form-data request (to handle file upload)
        const formDataToSend = new FormData();
        formDataToSend.append('name', formData.name);

        if (formData.emergency_phone) {
            formDataToSend.append('emergency_phone', formData.emergency_phone);
        }

        // Add display_emergency as 1 or 0
        formDataToSend.append('display_emergency', formData.display_emergency ? '1' : '0');

        if (formData.birthdate) {
            formDataToSend.append('birthdate', formData.birthdate);
        }

        if (formData.gender) {
            formDataToSend.append('gender', formData.gender);
        }

        if (formData.address) {
            formDataToSend.append('address', formData.address);
        }

        if (formData.nationality_id) {
            formDataToSend.append('country_id', formData.nationality_id.toString());
        }

        if (formData.marital_status) {
            formDataToSend.append('marital_status', formData.marital_status);
        }

        // Add profile image if selected
        if (profileImageFile.value) {
            formDataToSend.append('profile_image', profileImageFile.value);
        }

        // Send to API
        const response = await axios.post('/api/website/auth/profile', formDataToSend, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });

        // Update user data
        if (response.data.data?.user) {
            const userData = response.data.data.user;
            if (userData.profile_image_url) {
                profileImage.value = userData.profile_image_url;
            }
        }

        toast.success(t.value.profile.messages.successUpdate);

        // Reload user data
        await loadUser();
    } catch (error: any) {
        if (error.response?.status === 401) {
            // Unauthenticated
            toast.error(currentLocale.value === 'ar' ? 'يجب تسجيل الدخول أولاً' : 'Please login first');
            window.location.href = `/${currentLocale.value === 'ar' ? 'ar' : 'en'}/login`;
        } else if (error.response?.status === 422) {
            const responseErrors = error.response.data.errors || {};
            Object.keys(responseErrors).forEach(key => {
                if (key in errors) {
                    errors[key] = Array.isArray(responseErrors[key])
                        ? responseErrors[key][0]
                        : responseErrors[key];
                }
            });
        } else {
            toast.error(t.value.profile.messages.errorUpdate);
        }
    } finally {
        updating.value = false;
    }
};

// Reset form
const resetForm = () => {
    if (authUser.value) {
        formData.name = authUser.value.name || '';
        formData.email = authUser.value.email || '';
        formData.phone = authUser.value.phone || '';
        formData.emergency_phone = authUser.value.emergency_phone || '';
        formData.display_emergency = authUser.value.display_emergency || false;
        formData.birthdate = authUser.value.birthdate || '';
        formData.gender = authUser.value.gender || 'male';
        formData.address = authUser.value.address || '';
        formData.nationality_id = authUser.value.country_id || null;
        formData.marital_status = authUser.value.marital_status || '';

        // Reset profile image to original
        if (authUser.value.profile_image_url) {
            profileImage.value = authUser.value.profile_image_url;
        } else {
            profileImage.value = null;
        }

        // Clear file input
        profileImageFile.value = null;
    }
    resetErrors();
};

// Copy profile link to clipboard
const copyProfileLink = async () => {
    if (authUser.value?.hash_url) {
        const link = `${window.location.origin}/user/info/${authUser.value.hash_url}`;
        try {
            await navigator.clipboard.writeText(link);
            toast.success(t.value.profile.form.linkCopied || 'Link copied to clipboard!');
        } catch (err) {
            console.error('Failed to copy:', err);
            toast.error(t.value.profile.form.linkCopyFailed || 'Failed to copy link');
        }
    }
};

// Load user on mount
onMounted(async () => {
    // Initialize websiteStore and set router
    websiteStore.setRouter(router);

    // Try to load user data
    // If it fails with 401, the loadUser function will handle redirect
    await loadUser();
    fetchNationalities();
    fetchMaritalStatus();
});
</script>
