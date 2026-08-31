<template>
    <div class="profile-page">
        <!-- Navigation -->
        <Navigation/>

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
                            <div
                                class="w-full h-5 shadow-[inset_0_4px_4px_0_#00000040] flex items-center bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-4 bg-[#1BB2B1] rounded-full transition-all duration-300"
                                     :style="{ width: profileCompletion + '%' }"></div>
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
                                    <div :class="activeTab === 'personal' ? 'bg-white' : 'bg-white shadow-2xl'"
                                         class="p-5 rounded-xl flex items-center justify-center">
                                        <i :class="activeTab === 'personal' ? 'text-teal-500' : 'text-teal-500'"
                                           class="pi pi-user text-[22px]"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold">{{ t.profile.personalInfo.title }}</p>
                                        <p class="text-sm opacity-90">{{ t.profile.personalInfo.subtitle }}</p>
                                    </div>
                                </div>
                                <div class="text-xl" :class="activeTab === 'personal' ? 'text-white' : 'text-gray-400'">
                                    <i :class="isRTL ? 'pi-angle-left' : 'pi-angle-right'" class="pi"></i>
                                </div>
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
                                        <p class="font-semibold">{{ t.profile.medicalData?.title || 'البيانات الطبية' }}</p>
                                        <p class="text-sm opacity-90">{{ t.profile.medicalData?.subtitle || 'فصيلة الدم، الحساسية...' }}</p>
                                    </div>
                                </div>
                                <div class="text-xl" :class="activeTab === 'medical' ? 'text-white' : 'text-gray-400'">
                                    <i :class="isRTL ? 'pi-angle-left' : 'pi-angle-right'" class="pi"></i>
                                </div>
                            </div>

<!--                            &lt;!&ndash; Medical Archive Tab &ndash;&gt;-->
<!--                            <div-->
<!--                                @click="activeTab = 'archive'"-->
<!--                                :class="activeTab === 'archive' ? 'bg-teal-500 text-white shadow-xl' : 'bg-gray-100 text-[#123057]'"-->
<!--                                class="cursor-pointer hover:scale-102 transition-transform duration-300 ease-in-out rounded-3xl px-7 py-6 flex items-center justify-between shadow-md"-->
<!--                            >-->
<!--                                <div class="flex items-center gap-3">-->
<!--                                    <div :class="activeTab === 'archive' ? 'bg-white' : 'bg-white shadow-2xl'" class="p-5 rounded-xl flex items-center justify-center">-->
<!--                                        <i :class="activeTab === 'archive' ? 'text-teal-500' : 'text-teal-500'" class="pi pi-file text-[22px]"></i>-->
<!--                                    </div>-->
<!--                                    <div>-->
<!--                                        <p class="font-semibold">{{ t.profile.medicalArchive?.title || 'الأرشيف الطبي' }}</p>-->
<!--                                        <p class="text-sm opacity-90">{{ t.profile.medicalArchive?.subtitle || 'الأشعة والتقارير والروشتات...' }}</p>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="text-xl text-gray-400">-->
<!--                                    <i :class="isRTL ? 'pi-angle-left' : 'pi-angle-right'" class="pi"></i>-->
<!--                                </div>-->
<!--                            </div>-->

                            <!-- Medical Archive Tab (visible only with active subscription) -->
                            <div
                                v-if="hasActiveSubscription"
                                @click="activeTab = 'archive'"
                                :class="activeTab === 'archive' ? 'bg-teal-500 text-white shadow-xl' : 'bg-gray-100 text-[#123057]'"
                                class="cursor-pointer hover:scale-102 transition-transform duration-300 ease-in-out rounded-3xl px-7 py-6 flex items-center justify-between shadow-md"
                            >
                                <div class="flex items-center gap-3">
                                    <div :class="activeTab === 'archive' ? 'bg-white' : 'bg-white shadow-2xl'" class="p-5 rounded-xl flex items-center justify-center">
                                        <i :class="activeTab === 'archive' ? 'text-teal-500' : 'text-teal-500'" class="pi pi-folder text-[22px]"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold">{{ t.profile.medicalArchive?.title || 'الأرشيف الطبي' }}</p>
                                        <p class="text-sm opacity-90">{{ t.profile.medicalArchive?.subtitle || 'الأشعة والتقارير والروشتات...' }}</p>
                                    </div>
                                </div>
                                <div class="text-xl" :class="activeTab === 'archive' ? 'text-white' : 'text-gray-400'">
                                    <i :class="isRTL ? 'pi-angle-left' : 'pi-angle-right'" class="pi"></i>
                                </div>
                            </div>

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
                            <div
                                class="w-full h-5 shadow-[inset_0_4px_4px_0_#00000040] flex items-center bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-4 bg-[#1BB2B1] rounded-full transition-all duration-300"
                                     :style="{ width: profileCompletion + '%' }"></div>
                            </div>
                        </div>

                        <!-- Mobile Tab Switcher -->
                        <div class="flex gap-3">
                            <button
                                @click="activeTab = 'personal'"
                                :class="activeTab === 'personal' ? 'bg-teal-500 text-white shadow-xl' : 'bg-gray-100 text-[#123057]'"
                                class="flex-1 flex items-center justify-center gap-2 rounded-2xl px-4 py-3 font-semibold transition-all duration-300"
                            >
                                <i class="pi pi-user text-[18px]"></i>
                                <span class="text-sm">{{ t.profile.personalInfo.title }}</span>
                            </button>
                            <button
                                @click="activeTab = 'medical'"
                                :class="activeTab === 'medical' ? 'bg-teal-500 text-white shadow-xl' : 'bg-gray-100 text-[#123057]'"
                                class="flex-1 flex items-center justify-center gap-2 rounded-2xl px-4 py-3 font-semibold transition-all duration-300"
                            >
                                <i class="pi pi-heart text-[18px]"></i>
                                <span class="text-sm">{{ t.profile.medicalData?.title || 'البيانات الطبية' }}</span>
                            </button>
                            <button
                                v-if="hasActiveSubscription"
                                @click="activeTab = 'archive'"
                                :class="activeTab === 'archive' ? 'bg-teal-500 text-white shadow-xl' : 'bg-gray-100 text-[#123057]'"
                                class="flex-1 flex items-center justify-center gap-2 rounded-2xl px-4 py-3 font-semibold transition-all duration-300"
                            >
                                <i class="pi pi-folder text-[18px]"></i>
                                <span class="text-sm">{{ t.profile.medicalArchive?.title || 'الأرشيف الطبي' }}</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-span-2">
                    <!-- Personal Information Tab -->
                    <div v-show="activeTab === 'personal'"
                         class="bg-white p-10 rounded-[48px] shadow-xl transform transition duration-500 hover:shadow-2xl">
                        <div class="mb-4">
                            <h3 class="text-2xl font-bold mb-2">{{ t.profile.form.whoAreYou }}</h3>
                            <p class="text-gray-600 text-[14px] font-semibold">
                                {{ t.profile.form.whoAreYouSubtitle }}
                            </p>
                        </div>

                        <!-- Profile Image Upload -->
                        <div
                            class="bg-[#1BB2B1] shadow-[inset_0_4px_4px_0_#12305766] p-10 w-full rounded-3xl flex items-center justify-center mb-6">
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 rounded-[32px] bg-white relative shadow-2xl cursor-pointer overflow-hidden">
                                    <img v-if="!profileImage" :src="userVectorImg" alt="User"
                                         class="w-full h-full object-cover">
                                    <img v-else :src="profileImage" alt="Profile"
                                         class="w-full h-full object-cover">
                                    <input @change="handleImageUpload"
                                           class="opacity-0 w-full h-full absolute top-0 left-0 cursor-pointer rounded-[32px]"
                                           type="file" accept="image/*">
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
                                <div class="p-2 text-[#123057] flex flex-col col-span-2 lg:col-span-1 relative">
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
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ currentLocale === 'ar' ? 'لا يمكن تعديل البريد الإلكتروني' : 'Email address cannot be changed' }}
                                    </p>
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
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ currentLocale === 'ar' ? 'لا يمكن تعديل رقم الهاتف' : 'Phone number cannot be changed' }}
                                    </p>
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

                    <!-- Medical Data Tab -->
                    <div v-show="activeTab === 'medical'" class="bg-white p-10 rounded-[48px] shadow-xl transform transition duration-500 hover:shadow-2xl cursor-pointer relative overflow-hidden">
                        <div class="mb-10">
                            <h3 class="text-2xl font-bold mb-2">{{ t.profile.medicalForm.pageTitle }}</h3>
                            <p class="text-gray-600 text-[14px] font-semibold">
                                {{ t.profile.medicalForm.pageSubtitle }}
                            </p>
                        </div>

                        <form @submit.prevent="handleMedicalUpdate">
                            <div class="grid text-[#123057] grid-cols-2 gap-6">

                                <!-- Blood Type -->
                                <div class="flex text-[#123057] flex-col col-span-2 lg:col-span-1 relative">
                                    <label class="font-bold mb-2">{{ t.profile.medicalForm.bloodType }}</label>
                                    <div class="relative">
                                        <select
                                            v-model="medicalFormData.blood_type"
                                            class="bg-gray-50 border-0 shadow-xl font-semibold rounded-[30px] w-full p-4 pr-12 appearance-none focus:ring-0 focus:border-transparent"
                                        >
                                            <option value="">{{ t.profile.medicalForm.selectBloodType }}</option>
                                            <option value="A+">A+</option>
                                            <option value="A-">A-</option>
                                            <option value="B+">B+</option>
                                            <option value="B-">B-</option>
                                            <option value="AB+">AB+</option>
                                            <option value="AB-">AB-</option>
                                            <option value="O+">O+</option>
                                            <option value="O-">O-</option>
                                        </select>
                                        <i class="pi pi-heart absolute top-1/2 right-5 text-gray-400 -translate-y-1/2 text-[18px] pointer-events-none"></i>
                                    </div>
                                    <p v-if="medicalErrors.blood_type" class="text-red-500 text-sm mt-1">{{ medicalErrors.blood_type }}</p>
                                </div>

                                <!-- Emergency Phone -->
                                <div class="flex text-[#123057] flex-col col-span-2 lg:col-span-1 relative">
                                    <label class="font-bold mb-2">{{ t.profile.form.emergencyPhone }}</label>
                                    <div class="relative">
                                        <input
                                            v-model="medicalFormData.emergency_phone"
                                            type="text"
                                            dir="ltr"
                                            :placeholder="t.profile.form.emergencyPhonePlaceholder"
                                            class="bg-gray-50 focus:ring-0 focus:border-transparent border-0 shadow-xl font-semibold rounded-[30px] w-full p-4 pr-12"
                                        />
                                        <i class="pi pi-phone absolute top-1/2 right-5 text-gray-400 -translate-y-1/2 text-[18px]"></i>
                                    </div>
                                    <p v-if="medicalErrors.emergency_phone" class="text-red-500 text-sm mt-1">{{ medicalErrors.emergency_phone }}</p>
                                </div>

                                <!-- Display Emergency Toggle -->
                                <div class="flex text-[#123057] flex-col col-span-2 relative">
                                    <div class="bg-gray-50 border-0 shadow-xl rounded-[30px] p-6">
                                        <div class="flex items-center justify-between">
                                            <div class="flex-1">
                                                <label class="font-bold text-lg cursor-pointer">
                                                    {{ t.profile.form.displayEmergency }}
                                                </label>
                                                <p class="text-sm text-gray-600 mt-1">
                                                    {{ t.profile.form.displayEmergencyDesc }}
                                                </p>
                                            </div>
                                            <div class="flex-shrink-0 ml-4">
                                                <label class="relative inline-flex items-center cursor-pointer">
                                                    <input
                                                        type="checkbox"
                                                        v-model="medicalFormData.display_emergency"
                                                        class="sr-only peer"
                                                    >
                                                    <div class="w-14 h-7 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-teal-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-teal-500"></div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Emergency Profile Link -->
                                <div v-if="authUser?.hash_url" class="flex text-[#123057] flex-col col-span-2 relative">
                                    <div class="bg-[#FF6760] border-0 shadow-xl rounded-[30px] p-6">
                                        <div class="flex items-center justify-between">
                                            <div class="flex-1 text-white">
                                                <label class="font-bold text-lg">
                                                    {{ t.profile.form.emergencyProfileLink }}
                                                </label>
                                                <p class="text-sm text-white/90 mt-1">
                                                    {{ t.profile.form.emergencyProfileLinkDesc }}
                                                </p>
                                            </div>
                                            <div class="flex-shrink-0 ml-4">
                                                <a
                                                    :href="`/user/info/${authUser?.item?.uuid}`"
                                                    target="_blank"
                                                    class="inline-flex items-center gap-2 bg-white text-[#FF6760] font-bold px-6 py-3 rounded-full hover:bg-gray-100 transition duration-150 shadow-lg"
                                                >
                                                    <i class="pi pi-external-link"></i>
                                                    {{ t.profile.form.viewProfile }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Chronic Diseases / Allergies -->
                                <div class="flex text-[#123057] flex-col col-span-2 relative">
                                    <label class="font-bold mb-2">{{ t.profile.medicalForm.chronicDiseases }}</label>
                                    <MultiSelect
                                        v-model="selectedDiseases"
                                        :options="diseaseOptions"
                                        :placeholder="t.profile.medicalForm.chronicDiseasesPlaceholder"
                                        :no-results-text="currentLocale === 'ar' ? 'لا توجد نتائج' : 'No results found'"
                                    />
                                </div>

                                <!-- Other Medical Notes -->
                                <div class="flex text-[#123057] flex-col col-span-2 relative">
                                    <label class="font-bold mb-2">{{ t.profile.medicalForm.medicalNotes }}</label>
                                    <textarea
                                        v-model="medicalFormData.notes"
                                        rows="4"
                                        :placeholder="t.profile.medicalForm.medicalNotesPlaceholder"
                                        class="bg-gray-50 focus:ring-0 focus:border-transparent border-0 shadow-xl font-semibold rounded-[30px] w-full p-5 resize-none"
                                    ></textarea>
                                </div>

                            </div>

                            <div class="my-10 h-px bg-gray-200"></div>

                            <!-- Buttons -->
                            <div class="flex flex-col items-center justify-center">
                                <button
                                    type="submit"
                                    :disabled="updatingMedical"
                                    class="py-3 px-20 border-0 rounded-xl bg-[#123057] text-white font-bold hover:bg-[#0e2540] transition duration-150 disabled:opacity-50"
                                >
                                    <span v-if="!updatingMedical">{{ t.profile.form?.saveChanges || 'حفظ التغييرات' }}</span>
                                    <span v-else>{{ t.profile.form?.saving || 'جارٍ الحفظ...' }}</span>
                                </button>
                                <button
                                    type="button"
                                    @click="resetMedicalForm"
                                    class="py-3 px-20 border-0 text-gray-400 mt-4 font-semibold"
                                >
                                    {{ t.profile.form?.cancelChanges || 'إلغاء التعديلات' }}
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Medical Archive Tab -->
                    <div v-show="activeTab === 'archive'" class="bg-white p-6 lg:p-10 rounded-[48px] shadow-xl transform transition duration-500 hover:shadow-2xl">
                        <div class="mb-6 flex items-center justify-between flex-wrap gap-3">
                            <div>
                                <h3 class="text-2xl font-bold mb-1">{{ t.profile.medicalArchive?.title || 'الأرشيف الطبي' }}</h3>
                                <p class="text-gray-500 text-[14px] font-semibold">{{ t.profile.medicalArchive?.subtitle || 'الأشعة والتقارير والروشتات...' }}</p>
                            </div>
                            <button
                                @click="openAddFileModal"
                                class="flex items-center gap-2 py-3 px-6 rounded-2xl bg-[#123057] text-white font-bold hover:bg-[#0e2540] transition duration-150"
                            >
                                <i class="pi pi-plus text-[14px]"></i>
                                <span>{{ isRTL ? 'إضافة ملف' : 'Add File' }}</span>
                            </button>
                        </div>

                        <!-- Display Medical Archive Toggle -->
                        <div class="mb-6 bg-gray-50 border-0 shadow-xl rounded-[30px] p-6">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <label class="font-bold text-lg cursor-pointer text-[#123057]">
                                        {{ isRTL ? 'عرض الأرشيف الطبي للزوار' : 'Display Medical Archive to Visitors' }}
                                    </label>
                                    <p class="text-sm text-gray-600 mt-1">
                                        {{ isRTL ? 'السماح بعرض ملفاتك الطبية لمن يمسح رمز QR' : 'Allow your medical files to be visible to anyone scanning the QR code' }}
                                    </p>
                                </div>
                                <div class="flex-shrink-0 ml-4">
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input
                                            type="checkbox"
                                            v-model="archiveDisplayToggle"
                                            @change="saveArchiveDisplayToggle"
                                            class="sr-only peer"
                                        >
                                        <div class="w-14 h-7 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-teal-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-teal-500"></div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Category Tabs -->
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-8">
                            <div
                                v-for="cat in fileCategories"
                                :key="cat.value"
                                @click="activeFileCategory = cat.value; fetchMedicalFiles(1)"
                                :class="activeFileCategory === cat.value
                                    ? 'bg-[#123057] text-white shadow-xl'
                                    : 'bg-gray-100 text-gray-500 hover:text-teal-500'"
                                class="flex flex-col items-center justify-center gap-2 rounded-3xl py-5 cursor-pointer font-semibold transition"
                            >
                                <i :class="`pi ${cat.icon} text-2xl`"></i>
                                <span class="text-sm">{{ cat.label }}</span>
                            </div>
                        </div>

                        <!-- Loading -->
                        <div v-if="filesLoading" class="flex justify-center py-10">
                            <div class="w-8 h-8 border-4 border-teal-500 border-t-transparent rounded-full animate-spin"></div>
                        </div>

                        <!-- Empty State -->
                        <div v-else-if="!medicalFiles.length" class="flex flex-col items-center justify-center py-14 text-center text-gray-400">
                            <i class="pi pi-folder-open text-[55px] mb-4 text-gray-300"></i>
                            <p class="text-lg font-semibold">{{ isRTL ? 'لا توجد ملفات في هذا القسم' : 'No files in this category' }}</p>
                            <p class="text-sm mt-2">{{ isRTL ? 'اضغط على "إضافة ملف" لرفع أول ملف' : 'Click "Add File" to upload your first file' }}</p>
                        </div>

                        <!-- Files Grid -->
                        <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div
                                v-for="file in medicalFiles"
                                :key="file.id"
                                class="bg-gray-50 rounded-3xl p-5 shadow-md flex items-start gap-4 relative"
                            >
                                <!-- Category icon -->
                                <div class="shrink-0">
                                    <div class="w-16 h-16 rounded-2xl bg-teal-50 flex items-center justify-center border border-teal-100">
                                        <i :class="`pi ${file.category_icon} text-teal-500 text-2xl`"></i>
                                    </div>
                                </div>
                                <!-- Info -->
                                <div class="flex-1 min-w-0">
                                    <p class="font-bold text-[#123057] truncate">{{ file.title }}</p>
                                    <p v-if="file.doctor" class="text-sm text-gray-500 mt-0.5">
                                        <i class="pi pi-user me-1"></i>{{ file.doctor }}
                                    </p>
                                    <p class="text-xs text-gray-400 mt-1">{{ file.created_at }}</p>
                                    <span
                                        :class="file.is_active ? 'bg-teal-100 text-teal-700' : 'bg-gray-200 text-gray-400'"
                                        class="inline-flex items-center gap-1.5 mt-2 text-xs font-semibold px-3 py-1 rounded-full"
                                    >
                                        <span :class="file.is_active ? 'bg-teal-500' : 'bg-gray-400'" class="w-1.5 h-1.5 rounded-full inline-block"></span>
                                        {{ file.category_label }}
                                    </span>

                                    <!-- Attachments: images as a slider, files listed below -->
                                    <MedicalFileGallery
                                        v-if="fileAttachments(file).length"
                                        :attachments="fileAttachments(file)"
                                        :rtl="isRTL"
                                    />
                                </div>
                                <!-- Actions -->
                                <div class="flex flex-col gap-2 shrink-0">
                                    <button
                                        @click="openEditFileModal(file)"
                                        class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center hover:bg-blue-200 transition"
                                        :title="isRTL ? 'تعديل' : 'Edit'"
                                    >
                                        <i class="pi pi-pencil text-xs"></i>
                                    </button>
                                    <button
                                        @click="confirmDeleteFile(file)"
                                        class="w-8 h-8 rounded-full bg-red-100 text-red-500 flex items-center justify-center hover:bg-red-200 transition"
                                        :title="isRTL ? 'حذف' : 'Delete'"
                                    >
                                        <i class="pi pi-trash text-xs"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Pagination -->
                        <div v-if="filesMeta.lastPage > 1" class="flex items-center justify-center gap-2 mt-8">
                            <button
                                v-for="p in filesMeta.lastPage"
                                :key="p"
                                @click="fetchMedicalFiles(p)"
                                :class="p === filesMeta.currentPage
                                    ? 'bg-[#123057] text-white'
                                    : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                                class="w-9 h-9 rounded-full font-semibold text-sm transition"
                            >{{ p }}</button>
                        </div>
                    </div>

                    <!-- Medical File Modal (Add / Edit) -->
                    <Teleport to="body">
                        <div v-if="showFileModal" class="fixed inset-0 z-50 flex items-center justify-center p-4">
                            <div class="absolute inset-0 bg-black/40" @click="closeFileModal"></div>
                            <div class="relative bg-white rounded-[40px] shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto p-8 z-10">
                                <h3 class="text-xl font-bold mb-6">
                                    {{ editingFile ? (isRTL ? 'تعديل الملف' : 'Edit File') : (isRTL ? 'إضافة ملف جديد' : 'Add New File') }}
                                </h3>

                                <!-- Category selector -->
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-2 mb-6">
                                    <div
                                        v-for="cat in fileCategories"
                                        :key="cat.value"
                                        @click="fileForm.category = cat.value"
                                        :class="fileForm.category === cat.value
                                            ? 'bg-[#123057] text-white'
                                            : 'bg-gray-100 text-gray-500 hover:text-teal-500'"
                                        class="flex flex-col items-center gap-1 rounded-2xl py-3 cursor-pointer transition text-xs font-semibold"
                                    >
                                        <i :class="`pi ${cat.icon} text-lg`"></i>
                                        <span>{{ cat.label }}</span>
                                    </div>
                                </div>

                                <!-- Title -->
                                <div class="mb-4">
                                    <label class="font-bold mb-2 block">{{ isRTL ? 'عنوان المستند' : 'Document Title' }} <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <input v-model="fileForm.title" type="text"
                                            :class="fileErrors.title ? 'border border-red-400' : ''"
                                            class="bg-gray-50 border-0 shadow-md font-semibold rounded-[20px] w-full p-4 pr-12 focus:ring-0 focus:outline-none"
                                            :placeholder="isRTL ? 'عنوان المستند (الفحص)' : 'Document title'"
                                        >
                                        <i class="pi pi-file absolute top-1/2 right-5 -translate-y-1/2 text-gray-400 text-[16px]"></i>
                                    </div>
                                    <p v-if="fileErrors.title" class="text-red-500 text-xs mt-1">{{ fileErrors.title }}</p>
                                </div>

                                <!-- Doctor -->
                                <div class="mb-4">
                                    <label class="font-bold mb-2 block">{{ isRTL ? 'الطبيب المعالج' : 'Treating Doctor' }}</label>
                                    <div class="relative">
                                        <input v-model="fileForm.doctor" type="text"
                                            class="bg-gray-50 border-0 shadow-md font-semibold rounded-[20px] w-full p-4 pr-12 focus:ring-0 focus:outline-none"
                                            :placeholder="isRTL ? 'الطبيب المعالج' : 'Treating doctor'"
                                        >
                                        <i class="pi pi-user absolute top-1/2 right-5 -translate-y-1/2 text-gray-400 text-[16px]"></i>
                                    </div>
                                </div>

                                <!-- Existing attachments (edit mode) -->
                                <div v-if="editingFile && existingAttachments.length" class="mb-4">
                                    <label class="font-bold mb-2 block">{{ isRTL ? 'الملفات الحالية' : 'Current Files' }}</label>
                                    <div class="flex flex-wrap gap-2">
                                        <div
                                            v-for="(att, i) in existingAttachments"
                                            :key="att.id"
                                            class="inline-flex items-center gap-2 bg-gray-50 border border-gray-200 rounded-full ps-3 pe-1.5 py-1 text-xs"
                                        >
                                            <a :href="att.file_url" target="_blank" class="text-[#123057] font-semibold max-w-[120px] truncate">
                                                {{ att.original_name || (isRTL ? `ملف ${i + 1}` : `File ${i + 1}`) }}
                                            </a>
                                            <button type="button" @click="removeExistingAttachment(att.id)"
                                                class="w-5 h-5 rounded-full bg-red-100 text-red-500 flex items-center justify-center hover:bg-red-200 transition">
                                                <i class="pi pi-times text-[10px]"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- File upload (multiple) -->
                                <div class="mb-4">
                                    <label class="font-bold mb-2 block">{{ isRTL ? 'صور / ملفات المستند (يمكنك رفع أكثر من ملف)' : 'Document Files (you can upload multiple)' }}</label>
                                    <label class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-[20px] p-4 flex items-center justify-center gap-3 shadow-md cursor-pointer hover:border-teal-400 transition">
                                        <i class="pi pi-camera text-gray-400 text-xl"></i>
                                        <span class="text-gray-400 font-semibold text-sm">
                                            {{ isRTL ? 'رفع الملفات (jpg, png, pdf)' : 'Upload files (jpg, png, pdf)' }}
                                        </span>
                                        <input type="file" class="hidden" accept=".jpg,.jpeg,.png,.gif,.pdf" multiple @change="handleFileSelect">
                                    </label>
                                    <!-- Selected (not yet uploaded) files -->
                                    <div v-if="selectedFiles.length" class="flex flex-wrap gap-2 mt-2">
                                        <div
                                            v-for="(f, i) in selectedFiles"
                                            :key="i"
                                            class="inline-flex items-center gap-2 bg-teal-50 border border-teal-200 rounded-full ps-3 pe-1.5 py-1 text-xs"
                                        >
                                            <span class="text-teal-700 font-semibold max-w-[120px] truncate">{{ f.name }}</span>
                                            <button type="button" @click="removeSelectedFile(i)"
                                                class="w-5 h-5 rounded-full bg-red-100 text-red-500 flex items-center justify-center hover:bg-red-200 transition">
                                                <i class="pi pi-times text-[10px]"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <p v-if="fileErrors.files || fileErrors['files.0']" class="text-red-500 text-xs mt-1">{{ fileErrors.files || fileErrors['files.0'] }}</p>
                                </div>

                                <!-- Notes -->
                                <div class="mb-6">
                                    <label class="font-bold mb-2 block">{{ isRTL ? 'ملاحظاتك الإضافية' : 'Additional Notes' }}</label>
                                    <textarea v-model="fileForm.notes" rows="3"
                                        :placeholder="isRTL ? 'اكتب أي ملاحظة تريد تذكرها...' : 'Any additional notes...'"
                                        class="bg-gray-50 border-0 shadow-md font-semibold rounded-[20px] w-full p-4 resize-none focus:ring-0 focus:outline-none"
                                    ></textarea>
                                </div>

                                <div class="flex flex-col items-center gap-3">
                                    <button @click="submitFileForm" :disabled="fileSaving"
                                        class="py-3 px-20 rounded-xl bg-[#123057] text-white font-bold hover:bg-[#0e2540] transition duration-150 disabled:opacity-50"
                                    >
                                        <span v-if="!fileSaving">{{ isRTL ? 'حفظ' : 'Save' }}</span>
                                        <span v-else>{{ isRTL ? 'جارٍ الحفظ...' : 'Saving...' }}</span>
                                    </button>
                                    <button @click="closeFileModal" class="py-3 px-20 text-gray-400 font-semibold">
                                        {{ isRTL ? 'إلغاء' : 'Cancel' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </Teleport>

                    <!-- Delete Confirmation Modal -->
                    <Teleport to="body">
                        <div v-if="showDeleteFileModal" class="fixed inset-0 z-50 flex items-center justify-center p-4">
                            <div class="absolute inset-0 bg-black/40" @click="showDeleteFileModal = false"></div>
                            <div class="relative bg-white rounded-[32px] shadow-2xl w-full max-w-sm p-8 z-10 text-center">
                                <i class="pi pi-trash text-red-500 text-4xl mb-4"></i>
                                <h3 class="text-lg font-bold mb-2">{{ isRTL ? 'حذف الملف' : 'Delete File' }}</h3>
                                <p class="text-gray-500 text-sm mb-6">{{ isRTL ? 'هل أنت متأكد من حذف هذا الملف؟' : 'Are you sure you want to delete this file?' }}</p>
                                <div class="flex gap-3 justify-center">
                                    <button @click="showDeleteFileModal = false" class="py-2 px-6 rounded-xl bg-gray-100 text-gray-600 font-semibold">
                                        {{ isRTL ? 'إلغاء' : 'Cancel' }}
                                    </button>
                                    <button @click="deleteFile" :disabled="fileSaving" class="py-2 px-6 rounded-xl bg-red-500 text-white font-bold hover:bg-red-600 transition disabled:opacity-50">
                                        {{ isRTL ? 'حذف' : 'Delete' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </Teleport>
                </div>

            </div>
        </section>

        <!-- Footer -->
        <Footer/>
    </div>
</template>

<script setup lang="ts">
import { ref, reactive, onMounted, computed, watch } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useHead } from '@vueuse/head';
import { useAuth } from '../../../composables/useAuth';
import { useToast } from 'vue-toastification';
import { useWebsiteStore } from '../../../stores/websiteStore';
import axios from 'axios';
import userVectorImg from '../../../images/website/user-vector.png';

// Import layout components
import Navigation from '../Navigation.vue';
import Footer from '../Footer.vue';
import MedicalFileGallery from '../MedicalFileGallery.vue';
import MultiSelect, { type SelectOption } from '../forms/MultiSelect.vue';

// window.location.origin غير متاح مباشرة في الـ template في Vue 3
const origin = window.location.origin;

const router = useRouter();
const route = useRoute();
const { user: authUser, fetchUser } = useAuth();
const toast = useToast();
const websiteStore = useWebsiteStore();

// Get translations
const t = computed(() => websiteStore.t);
const currentLocale = computed(() => websiteStore.locale);
const isRTL = computed(() => websiteStore.isRTL);

const hasActiveSubscription = computed(() => authUser.value?.subscription?.status === 'active');

// ─── Medical Archive display toggle ──────────────────────────────────────────
const archiveDisplayToggle = ref(false);

const saveArchiveDisplayToggle = async (): Promise<void> => {
    try {
        await axios.put('/api/website/medical-info', {
            display_medical_archive: archiveDisplayToggle.value,
        }, { params: { lang: currentLocale.value } });
        toast.success(isRTL.value ? 'تم الحفظ' : 'Saved');
    } catch {
        toast.error(isRTL.value ? 'حدث خطأ' : 'An error occurred');
        archiveDisplayToggle.value = !archiveDisplayToggle.value; // revert on error
    }
};

// ─── Medical Archive ──────────────────────────────────────────────────────────

const fileCategories = ref<Array<{ value: string; label: string; icon: string }>>([]);
const activeFileCategory = ref('analyses');
const medicalFiles = ref<any[]>([]);
const filesLoading = ref(false);
const filesMeta = ref({ currentPage: 1, lastPage: 1 });

const showFileModal = ref(false);
const showDeleteFileModal = ref(false);
const editingFile = ref<any>(null);
const deletingFile = ref<any>(null);
const fileSaving = ref(false);
const selectedFiles = ref<File[]>([]);
const existingAttachments = ref<Array<{ id: number; file_url: string; original_name?: string }>>([]);
const removeAttachmentIds = ref<number[]>([]);
const fileErrors = ref<Record<string, string>>({});

const fileForm = reactive({
    title: '',
    category: 'analyses',
    doctor: '',
    notes: '',
});

const fetchFileCategories = async (): Promise<void> => {
    try {
        const response = await axios.get('/api/website/medical-files/categories', {
            params: { lang: currentLocale.value },
        });
        fileCategories.value = response.data.data?.categories || [];
    } catch (e) {
        console.error('Failed to fetch file categories', e);
    }
};

const fetchMedicalFiles = async (page = 1): Promise<void> => {
    filesLoading.value = true;
    try {
        const response = await axios.get('/api/website/medical-files', {
            params: {
                category: activeFileCategory.value,
                per_page: 12,
                page,
                lang: currentLocale.value,
            },
        });
        medicalFiles.value = response.data.data || [];
        const meta = response.data.pagination?.meta?.page;
        filesMeta.value = {
            currentPage: meta?.current ?? 1,
            lastPage: meta?.last ?? 1,
        };
    } catch (e) {
        console.error('Failed to fetch medical files', e);
    } finally {
        filesLoading.value = false;
    }
};

const openAddFileModal = (): void => {
    editingFile.value = null;
    fileForm.title = '';
    fileForm.category = activeFileCategory.value;
    fileForm.doctor = '';
    fileForm.notes = '';
    selectedFiles.value = [];
    existingAttachments.value = [];
    removeAttachmentIds.value = [];
    fileErrors.value = {};
    showFileModal.value = true;
};

const openEditFileModal = (file: any): void => {
    editingFile.value = file;
    fileForm.title = file.title;
    fileForm.category = file.category;
    fileForm.doctor = file.doctor || '';
    fileForm.notes = file.notes || '';
    selectedFiles.value = [];
    existingAttachments.value = [...fileAttachments(file)].filter((a: any) => a.id);
    removeAttachmentIds.value = [];
    fileErrors.value = {};
    showFileModal.value = true;
};

const closeFileModal = (): void => {
    showFileModal.value = false;
};

const handleFileSelect = (e: Event): void => {
    const target = e.target as HTMLInputElement;
    if (target.files?.length) {
        selectedFiles.value.push(...Array.from(target.files));
    }
    target.value = '';
};

const removeSelectedFile = (index: number): void => {
    selectedFiles.value.splice(index, 1);
};

const removeExistingAttachment = (id: number): void => {
    existingAttachments.value = existingAttachments.value.filter((a) => a.id !== id);
    removeAttachmentIds.value.push(id);
};

/**
 * Return a record's attachments, falling back to the legacy single file.
 */
const fileAttachments = (file: any): Array<{ id?: number; file_url: string; original_name?: string }> => {
    if (Array.isArray(file.attachments) && file.attachments.length) {
        return file.attachments;
    }
    return file.file_url ? [{ file_url: file.file_url }] : [];
};

const submitFileForm = async (): Promise<void> => {
    fileErrors.value = {};
    fileSaving.value = true;

    const formData = new FormData();
    formData.append('title', fileForm.title);
    formData.append('category', fileForm.category);
    if (fileForm.doctor) { formData.append('doctor', fileForm.doctor); }
    if (fileForm.notes) { formData.append('notes', fileForm.notes); }
    selectedFiles.value.forEach((f) => formData.append('files[]', f));
    removeAttachmentIds.value.forEach((id) => formData.append('remove_attachment_ids[]', String(id)));

    try {
        if (editingFile.value) {
            const response = await axios.post(
                `/api/website/medical-files/${editingFile.value.id}`,
                formData,
                { headers: { 'Content-Type': 'multipart/form-data' } }
            );
            const idx = medicalFiles.value.findIndex((f: any) => f.id === editingFile.value.id);
            if (idx !== -1) { medicalFiles.value[idx] = response.data.data; }
        } else {
            const response = await axios.post('/api/website/medical-files', formData, {
                headers: { 'Content-Type': 'multipart/form-data' },
            });
            medicalFiles.value.unshift(response.data.data);
        }
        closeFileModal();
        toast.success(isRTL.value ? 'تم حفظ الملف بنجاح' : 'File saved successfully');
    } catch (err: any) {
        if (err.response?.status === 422) {
            const errs = err.response.data?.errors || {};
            fileErrors.value = Object.fromEntries(
                Object.entries(errs).map(([k, v]) => [k, (v as string[])[0]])
            );
        } else {
            toast.error(isRTL.value ? 'حدث خطأ أثناء الحفظ' : 'Failed to save file');
        }
    } finally {
        fileSaving.value = false;
    }
};

const confirmDeleteFile = (file: any): void => {
    deletingFile.value = file;
    showDeleteFileModal.value = true;
};

const deleteFile = async (): Promise<void> => {
    if (!deletingFile.value) { return; }
    fileSaving.value = true;
    try {
        await axios.delete(`/api/website/medical-files/${deletingFile.value.id}`);
        medicalFiles.value = medicalFiles.value.filter((f: any) => f.id !== deletingFile.value.id);
        showDeleteFileModal.value = false;
        toast.success(isRTL.value ? 'تم حذف الملف' : 'File deleted');
    } catch {
        toast.error(isRTL.value ? 'حدث خطأ أثناء الحذف' : 'Failed to delete file');
    } finally {
        fileSaving.value = false;
    }
};

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
const updatingMedical = ref(false);

// Medical form errors
const medicalErrors = reactive<Record<string, string>>({});

// Options for selects
const nationalities = ref<Array<{ id: number; name_ar: string; name_en: string }>>([]);
const maritalStatusOptions = ref<Array<{ value: string; label_ar: string; label_en: string }>>([]);

// Form data
const formData = reactive({
    name: '',
    email: '',           // Read-only, not sent in update
    phone: '',           // Read-only, not sent in update
    birthdate: '',
    gender: 'male',
    address: '',
    nationality_id: null as number | null,
    marital_status: '',
});

// Medical form data
const medicalFormData = reactive({
    blood_type: '',
    emergency_phone: '',
    display_emergency: false,
    notes: '',
});

// Diseases multi-select
const selectedDiseases = ref<SelectOption[]>([]);
const diseaseOptions = ref<SelectOption[]>([]);

// Errors
const errors = reactive<Record<string, string>>({
    name: '',
    email: '',
    phone: '',
});

// Profile completion calculation
const profileCompletion = computed(() => {
    let completed = 0;
    const fields = [
        'name', 'email', 'phone',
        'birthdate', 'gender', 'address', 'nationality_id', 'marital_status',
    ];

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
    errors.name  = '';
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

// Fetch chronic diseases from API based on current locale
const fetchDiseases = async () => {
    try {
        const response = await axios.get('/api/website/diseases', {
            params: { lang: currentLocale.value },
        });
        diseaseOptions.value = (response.data.data.diseases || []).map((d: { id: number; name: string }) => ({
            id: d.id,
            name: d.name,
        }));
    } catch (error) {
        console.error('Error fetching diseases:', error);
    }
};

// Load user data
const loadUser = async () => {
    try {
        await fetchUser();
        if (authUser.value) {
            formData.name           = authUser.value.name || '';
            formData.email          = authUser.value.email || '';
            formData.phone          = authUser.value.phone || '';
            formData.birthdate      = authUser.value.birthdate || '';
            formData.gender         = authUser.value.gender || 'male';
            formData.address        = authUser.value.address || '';
            formData.nationality_id = authUser.value.country_id || null;
            formData.marital_status = authUser.value.marital_status || '';

            if (authUser.value.profile_image_url) {
                profileImage.value = authUser.value.profile_image_url;
            }

            // Populate medical form
            medicalFormData.emergency_phone   = authUser.value.emergency_phone || '';
            medicalFormData.display_emergency = authUser.value.display_emergency || false;
            archiveDisplayToggle.value = authUser.value.display_medical_archive || false;
            if (authUser.value.medical_info) {
                medicalFormData.blood_type = authUser.value.medical_info.blood_type || '';
                medicalFormData.notes      = authUser.value.medical_info.notes || '';
            }

            // Populate selected diseases
            if (authUser.value.diseases?.length) {
                selectedDiseases.value = authUser.value.diseases.map(d => ({
                    id: d.id,
                    name: typeof d.name === 'object'
                        ? (d.name[currentLocale.value] ?? d.name['ar'] ?? Object.values(d.name)[0])
                        : d.name,
                }));
            }
        }
    } catch (error: any) {
        console.error('Error loading user:', error);

        if (error.response?.status === 401) {
            toast.error(currentLocale.value === 'ar' ? 'يجب تسجيل الدخول أولاً' : 'Please login first');
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
        profileImageFile.value = file;

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
        const formDataToSend = new FormData();
        formDataToSend.append('name', formData.name);


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

        if (profileImageFile.value) {
            formDataToSend.append('profile_image', profileImageFile.value);
        }

        const response = await axios.post('/api/website/auth/profile', formDataToSend, {
            headers: { 'Content-Type': 'multipart/form-data' },
        });

        if (response.data.data?.user?.profile_image_url) {
            profileImage.value = response.data.data.user.profile_image_url;
        }

        toast.success(t.value.profile.messages.successUpdate);
        await loadUser();

    } catch (error: any) {
        if (error.response?.status === 401) {
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
        formData.name           = authUser.value.name || '';
        formData.email          = authUser.value.email || '';
        formData.phone          = authUser.value.phone || '';
        formData.birthdate      = authUser.value.birthdate || '';
        formData.gender         = authUser.value.gender || 'male';
        formData.address        = authUser.value.address || '';
        formData.nationality_id = authUser.value.country_id || null;
        formData.marital_status = authUser.value.marital_status || '';

        profileImage.value     = authUser.value.profile_image_url || null;
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

// Handle medical form update
const handleMedicalUpdate = async () => {
    updatingMedical.value = true;
    Object.keys(medicalErrors).forEach(k => delete medicalErrors[k]);

    try {
        const payload: Record<string, unknown> = {
            disease_ids:       selectedDiseases.value.map(d => d.id),
            display_emergency: medicalFormData.display_emergency,
        };

        if (medicalFormData.blood_type)     payload.blood_type     = medicalFormData.blood_type;
        if (medicalFormData.emergency_phone) payload.emergency_phone = medicalFormData.emergency_phone;
        if (medicalFormData.notes)           payload.notes           = medicalFormData.notes;

        const response = await axios.put('/api/website/medical-info', payload, {
            params: { lang: currentLocale.value },
        });

        // Refresh selected diseases list from response (translated names)
        const returnedDiseases = response.data.data.diseases || [];
        selectedDiseases.value = returnedDiseases.map((d: { id: number; name: string }) => ({
            id: d.id,
            name: d.name,
        }));

        toast.success(currentLocale.value === 'ar' ? 'تم حفظ البيانات الطبية بنجاح' : 'Medical data saved successfully');

    } catch (error: any) {
        if (error.response?.status === 422) {
            const responseErrors = error.response.data.errors || {};
            Object.keys(responseErrors).forEach(key => {
                medicalErrors[key] = Array.isArray(responseErrors[key])
                    ? responseErrors[key][0]
                    : responseErrors[key];
            });
        } else if (error.response?.status === 401) {
            toast.error(currentLocale.value === 'ar' ? 'يجب تسجيل الدخول أولاً' : 'Please login first');
            window.location.href = `/${currentLocale.value === 'ar' ? 'ar' : 'en'}/login`;
        } else {
            toast.error(currentLocale.value === 'ar' ? 'حدث خطأ، يرجى المحاولة مرة أخرى' : 'An error occurred, please try again');
        }
    } finally {
        updatingMedical.value = false;
    }
};

// Reset medical form
const resetMedicalForm = () => {
    medicalFormData.blood_type        = authUser.value?.medical_info?.blood_type || '';
    medicalFormData.emergency_phone   = authUser.value?.emergency_phone || '';
    medicalFormData.display_emergency = authUser.value?.display_emergency || false;
    medicalFormData.notes             = authUser.value?.medical_info?.notes || '';
    archiveDisplayToggle.value        = authUser.value?.display_medical_archive || false;
    selectedDiseases.value            = (authUser.value?.diseases || []).map(d => ({
        id: d.id,
        name: typeof d.name === 'object'
            ? (d.name[currentLocale.value] ?? d.name['ar'] ?? Object.values(d.name)[0])
            : d.name,
    }));
    Object.keys(medicalErrors).forEach(k => delete medicalErrors[k]);
};

// Load user on mount
onMounted(async () => {
    websiteStore.setRouter(router);
    const queryTab = route.query.tab;
    if (typeof queryTab === 'string' && ['personal', 'medical', 'archive'].includes(queryTab)) {
        activeTab.value = queryTab;
    }
    await loadUser();
    fetchNationalities();
    fetchMaritalStatus();
    fetchDiseases();
    fetchFileCategories();
});

watch(activeTab, (tab) => {
    // Keep the active tab in the URL so a refresh restores it
    if (route.query.tab !== tab) {
        router.replace({ query: { ...route.query, tab } }).catch(() => {});
    }
    if (tab === 'archive' && !medicalFiles.value.length) {
        fetchMedicalFiles(1);
    }
});
</script>
