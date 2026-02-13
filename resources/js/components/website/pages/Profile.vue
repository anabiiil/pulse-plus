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
                            <span class="font-medium">اكتمال الملف</span>
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
                                    <p class="font-semibold">المعلومات الشخصية</p>
                                    <p class="text-sm opacity-90">الاسم، الميلاد، العنوان</p>
                                </div>
                            </div>
                            <div class="text-xl text-gray-400"><i class="pi pi-angle-left"></i></div>
                        </div>

                        <!-- Medical Data Tab -->
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

                        <!-- Medical Archive Tab -->
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
                    </div>
                </div>

                <!-- Security Notice -->
                <div class="mt-8 py-20 my-4 bg-[#0E2A4F] text-white rounded-[48px] px-10 relative">
                    <div class="my-5">
                        <i class="pi pi-shield font-bold text-[35px]"></i>
                    </div>
                    <h3 class="font-semibold mb-2 text-[20px]">بياناتك في أمان</h3>
                    <p class="text-sm leading-relaxed text-white/80">
                        نستخدم أعلى معايير التشفير لضمان أن بياناتك متاحة فقط لمن تسمح لهم في حالات الطوارئ
                    </p>
                </div>

                <!-- Profile Completion Card (Mobile) -->
                <div class="lg:hidden my-4 block bg-white rounded-[48px] shadow-xl p-8">
                    <div class="mb-6">
                        <div class="flex justify-between text-sm text-teal-600 mb-2">
                            <span class="font-medium">اكتمال الملف</span>
                            <span>{{ profileCompletion }}%</span>
                        </div>
                        <div class="w-full h-5 shadow-[inset_0_4px_4px_0_#00000040] flex items-center bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-4 bg-[#1BB2B1] rounded-full transition-all duration-300" :style="{ width: profileCompletion + '%' }"></div>
                        </div>
                    </div>
                </div>

                <!-- Copyright (Desktop) -->
                <p class="hidden lg:block text-center text-xs text-gray-400 mt-6 border-t border-gray-400 pt-5">
                    جميع الحقوق محفوظة © Pulse
                </p>
            </div>

            <!-- Main Content -->
            <div class="col-span-2">
                <!-- Personal Information Tab -->
                <div v-show="activeTab === 'personal'" class="bg-white p-10 rounded-[48px] shadow-xl transform transition duration-500 hover:shadow-2xl">
                    <div class="mb-4">
                        <h3 class="text-2xl font-bold mb-2">من أنت؟</h3>
                        <p class="text-gray-600 text-[14px] font-semibold">
                            أدخل معلوماتك الأساسية كما تحب أن تظهر في هويتك الرقمية.
                        </p>
                    </div>

                    <!-- Profile Image Upload -->
                    <div class="bg-[#1BB2B1] shadow-[inset_0_4px_4px_0_#12305766] p-10 w-full rounded-3xl flex items-center justify-center mb-6">
                        <div class="flex flex-col items-center">
                            <div class="p-7 w-fit rounded-4xl bg-white relative shadow-2xl cursor-pointer">
                                <img v-if="!profileImage" :src="userVectorImg" alt="User" class="w-20 h-20">
                                <img v-else :src="profileImage" alt="Profile" class="w-20 h-20 rounded-full object-cover">
                                <input @change="handleImageUpload" class="opacity-0 w-full h-full absolute top-0 left-0 cursor-pointer" type="file" accept="image/*">
                            </div>
                            <div class="text-center text-white mt-4">
                                <h3 class="font-bold text-xl">صورة العضو</h3>
                                <p>قم بتحميل صورة واضحة للعضو لأغراض التعرف عليه.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Form -->
                    <form @submit.prevent="handleUpdate">
                        <div class="grid lg:grid-cols-2 grid-cols-1">
                            <!-- Full Name -->
                            <div class="p-2 text-[#123057] flex flex-col col-span-2 relative">
                                <label class="font-bold">الاسم بالكامل</label>
                                <div class="relative">
                                    <input
                                        v-model="formData.name"
                                        type="text"
                                        placeholder="ادخل اسمك الثلاثي..."
                                        class="focus:ring-0 focus:border-transparent bg-gray-50 border-0 transition-shadow duration-300 ease-in-out hover:shadow-2xl cursor-pointer shadow-xl font-semibold rounded-[30px] w-full p-4 my-2 pr-12"
                                    >
                                    <i class="pi pi-user absolute top-1/2 right-5 text-gray-400 text-[18px] -translate-y-1/2"></i>
                                </div>
                                <p v-if="errors.name" class="text-red-500 text-sm mt-1">{{ errors.name }}</p>
                            </div>

                            <!-- Birth Date -->
                            <div class="p-2 text-[#123057] flex flex-col col-span-2 lg:col-span-1 relative">
                                <label class="font-bold">تاريخ الميلاد</label>
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
                                <label class="font-bold">الجنس</label>
                                <div class="relative">
                                    <select
                                        v-model="formData.gender"
                                        class="focus:ring-0 focus:border-transparent bg-gray-50 border-0 shadow-xl transition-shadow duration-300 ease-in-out hover:shadow-2xl cursor-pointer font-semibold rounded-[30px] w-full p-4 my-2 pr-12"
                                    >
                                        <option value="male">ذكر</option>
                                        <option value="female">أنثى</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="p-2 text-[#123057] flex flex-col col-span-2 lg:col-span-1 relative">
                                <label class="font-bold">رقم الهاتف</label>
                                <div class="relative">
                                    <input
                                        v-model="formData.phone"
                                        type="text"
                                        placeholder="رقم الهاتف"
                                        dir="ltr"
                                        class="focus:ring-0 focus:border-transparent bg-gray-50 border-0 shadow-xl transition-shadow duration-300 ease-in-out hover:shadow-2xl cursor-pointer font-semibold rounded-[30px] w-full p-4 my-2 pr-12"
                                    >
                                    <i class="pi pi-phone absolute top-1/2 text-gray-400 right-5 text-[18px] -translate-y-1/2"></i>
                                </div>
                                <p v-if="errors.phone" class="text-red-500 text-sm mt-1">{{ errors.phone }}</p>
                            </div>

                            <!-- Address -->
                            <div class="p-2 text-[#123057] flex flex-col col-span-2 lg:col-span-1 relative">
                                <label class="font-bold">العنوان</label>
                                <div class="relative">
                                    <input
                                        v-model="formData.address"
                                        type="text"
                                        placeholder="العنوان"
                                        class="focus:ring-0 focus:border-transparent bg-gray-50 border-0 shadow-xl transition-shadow duration-300 ease-in-out hover:shadow-2xl cursor-pointer font-semibold rounded-[30px] w-full p-4 my-2 pr-12"
                                    >
                                    <i class="pi pi-map-marker absolute top-1/2 text-gray-400 right-5 text-[18px] -translate-y-1/2"></i>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="p-2 text-[#123057] flex flex-col col-span-2 relative">
                                <label class="font-bold">الايميل</label>
                                <div class="relative">
                                    <input
                                        v-model="formData.email"
                                        type="email"
                                        placeholder="الايميل"
                                        dir="ltr"
                                        class="focus:ring-0 focus:border-transparent bg-gray-50 border-0 shadow-xl transition-shadow duration-300 ease-in-out hover:shadow-2xl cursor-pointer font-semibold rounded-[30px] w-full p-4 my-2 pr-12"
                                    >
                                    <i class="pi pi-envelope absolute top-1/2 text-gray-400 right-5 text-[18px] -translate-y-1/2"></i>
                                </div>
                                <p v-if="errors.email" class="text-red-500 text-sm mt-1">{{ errors.email }}</p>
                            </div>

                            <!-- Nationality -->
                            <div class="p-2 text-[#123057] flex flex-col col-span-2 lg:col-span-1 relative">
                                <label class="font-bold">الجنسية</label>
                                <div class="relative">
                                    <select
                                        v-model="formData.nationality"
                                        class="focus:ring-0 focus:border-transparent bg-gray-50 border-0 shadow-xl transition-shadow duration-300 ease-in-out hover:shadow-2xl cursor-pointer font-semibold rounded-[30px] w-full p-4 my-2 pr-12"
                                    >
                                        <option value="foreign">أجنبي</option>
                                        <option value="arab">عربي</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Marital Status -->
                            <div class="p-2 text-[#123057] flex flex-col col-span-2 lg:col-span-1 relative">
                                <label class="font-bold">الحالة الاجتماعية</label>
                                <div class="relative">
                                    <input
                                        v-model="formData.marital_status"
                                        type="text"
                                        placeholder="الحالة الاجتماعية"
                                        class="focus:ring-0 focus:border-transparent bg-gray-50 border-0 transition-shadow duration-300 ease-in-out hover:shadow-2xl cursor-pointer shadow-xl font-semibold rounded-[30px] w-full p-4 my-2 pr-12"
                                    >
                                    <i class="pi pi-users absolute top-1/2 text-gray-400 right-5 text-[18px] -translate-y-1/2"></i>
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
                                <span v-if="!updating">حفظ التغييرات</span>
                                <span v-else>جاري الحفظ...</span>
                            </button>
                            <button
                                type="button"
                                @click="resetForm"
                                class="py-3 px-20 border-0 text-gray-400 mt-4 font-semibold"
                            >
                                إلغاء التعديلات
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Medical Data Tab -->
                <div v-show="activeTab === 'medical'" class="bg-white p-10 rounded-[48px] shadow-xl">
                    <h3 class="text-2xl font-bold mb-4">البيانات الطبية</h3>
                    <p class="text-gray-600">هذا القسم قيد التطوير...</p>
                </div>

                <!-- Medical Archive Tab -->
                <div v-show="activeTab === 'archive'" class="bg-white p-10 rounded-[48px] shadow-xl">
                    <h3 class="text-2xl font-bold mb-4">الأرشيف الطبي</h3>
                    <p class="text-gray-600">هذا القسم قيد التطوير...</p>
                </div>
            </div>

            <!-- Copyright (Mobile) -->
            <p class="lg:hidden block text-center text-xs text-gray-400 mt-6 border-t border-gray-400 pt-5">
                جميع الحقوق محفوظة © Pulse
            </p>
        </div>
    </section>

    <!-- Footer -->
    <Footer />
</div>
</template>

<script setup lang="ts">
import { ref, reactive, onMounted, computed } from 'vue';
import { useHead } from '@vueuse/head';
import { useAuth } from '../../../composables/useAuth';
import { useToast } from 'vue-toastification';
import userVectorImg from '../../../images/website/user-vector.png';

// Import layout components
import Navigation from '../Navigation.vue';
import Footer from '../Footer.vue';

const { user: authUser, fetchUser, updateProfile } = useAuth();
const toast = useToast();

useHead({
    title: 'الملف الشخصي - Pulse',
});

// Active tab state
const activeTab = ref('personal');

// Profile image
const profileImage = ref<string | null>(null);

// Loading states
const updating = ref(false);

// Form data
const formData = reactive({
    name: '',
    email: '',
    phone: '',
    birthdate: '',
    gender: 'male',
    address: '',
    nationality: 'arab',
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
    const fields = ['name', 'email', 'phone', 'birthdate', 'gender', 'address', 'nationality', 'marital_status'];

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

// Load user data
const loadUser = async () => {
    try {
        await fetchUser();
        if (authUser.value) {
            formData.name = authUser.value.name || '';
            formData.email = authUser.value.email || '';
            formData.phone = authUser.value.phone || '';
        }
    } catch (error) {
        console.error('Error loading user:', error);
        toast.error('فشل تحميل بيانات المستخدم');
    }
};

// Handle image upload
const handleImageUpload = (event: Event) => {
    const target = event.target as HTMLInputElement;
    const file = target.files?.[0];

    if (file) {
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
        await updateProfile({
            name: formData.name,
            email: formData.email,
            phone: formData.phone,
        });

        toast.success('تم تحديث الملف الشخصي بنجاح!');
    } catch (error: any) {
        if (error.response?.status === 422) {
            const responseErrors = error.response.data.errors || {};
            Object.keys(responseErrors).forEach(key => {
                if (key in errors) {
                    errors[key] = Array.isArray(responseErrors[key])
                        ? responseErrors[key][0]
                        : responseErrors[key];
                }
            });
        } else {
            toast.error('فشل تحديث الملف الشخصي');
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
    }
    resetErrors();
};

// Load user on mount
onMounted(() => {
    loadUser();
});
</script>
