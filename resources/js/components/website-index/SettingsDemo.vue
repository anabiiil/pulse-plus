<template>
  <div class="settings-demo p-8 bg-gray-100">
    <h1 class="text-3xl font-bold mb-6">Settings Demo - LTR Content Example</h1>

    <!-- Language Switcher -->
    <div class="mb-8">
      <button
        @click="appStore.toggleLocale()"
        class="bg-blue-500 text-white px-4 py-2 rounded"
      >
        Switch to {{ appStore.locale === 'ar' ? 'English' : 'Arabic' }}
      </button>
      <span class="ml-4">Current: {{ appStore.locale === 'ar' ? 'العربية' : 'English' }}</span>
    </div>

    <!-- Contact Info Section (Always LTR) -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
      <h2 class="text-2xl font-semibold mb-4">
        {{ appStore.locale === 'ar' ? 'معلومات الاتصال' : 'Contact Information' }}
      </h2>

      <div class="space-y-3">
        <!-- Email - Always LTR -->
        <div class="flex items-center gap-3">
          <i class="fas fa-envelope text-blue-500 w-6"></i>
          <span class="font-semibold" :class="appStore.isRTL ? 'ml-2' : 'mr-2'">
            {{ appStore.locale === 'ar' ? 'البريد الإلكتروني:' : 'Email:' }}
          </span>
          <span dir="ltr" style="text-align: inherit;" class="text-gray-700">
            {{ getSettingContent('contact_email') || 'info@pulse-plus.com' }}
          </span>
        </div>

        <!-- Phone - Always LTR -->
        <div class="flex items-center gap-3">
          <i class="fas fa-phone text-green-500 w-6"></i>
          <span class="font-semibold" :class="appStore.isRTL ? 'ml-2' : 'mr-2'">
            {{ appStore.locale === 'ar' ? 'الهاتف:' : 'Phone:' }}
          </span>
          <span dir="ltr" style="text-align: inherit;" class="text-gray-700">
            {{ getSettingContent('contact_phone') || '+2 01022335566' }}
          </span>
        </div>

        <!-- WhatsApp - Always LTR -->
        <div class="flex items-center gap-3" v-if="hasSetting('whatsapp_number')">
          <i class="fab fa-whatsapp text-green-600 w-6"></i>
          <span class="font-semibold" :class="appStore.isRTL ? 'ml-2' : 'mr-2'">
            {{ appStore.locale === 'ar' ? 'واتساب:' : 'WhatsApp:' }}
          </span>
          <span dir="ltr" style="text-align: inherit;" class="text-gray-700">
            {{ getSettingContent('whatsapp_number') }}
          </span>
        </div>
      </div>
    </div>

    <!-- Multilingual Content Section -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
      <h2 class="text-2xl font-semibold mb-4">
        {{ appStore.locale === 'ar' ? 'محتوى متعدد اللغات' : 'Multilingual Content' }}
      </h2>

      <!-- Description - Changes based on language -->
      <div class="mb-4">
        <h3 class="font-semibold mb-2">
          {{ appStore.locale === 'ar' ? 'الوصف:' : 'Description:' }}
        </h3>
        <p class="text-gray-700">
          {{ getSettingContent('footer_description') || 'No description available' }}
        </p>
      </div>

      <!-- About Us - Changes based on language -->
      <div class="mb-4" v-if="hasSetting('about_us')">
        <h3 class="font-semibold mb-2">
          {{ appStore.locale === 'ar' ? 'عنا:' : 'About Us:' }}
        </h3>
        <p class="text-gray-700">
          {{ getSettingContent('about_us') }}
        </p>
      </div>

      <!-- Address - Changes based on language -->
      <div v-if="hasSetting('address')">
        <h3 class="font-semibold mb-2">
          {{ appStore.locale === 'ar' ? 'العنوان:' : 'Address:' }}
        </h3>
        <p class="text-gray-700">
          {{ getSettingContent('address') }}
        </p>
      </div>
    </div>

    <!-- Social Media Links -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
      <h2 class="text-2xl font-semibold mb-4">
        {{ appStore.locale === 'ar' ? 'وسائل التواصل الاجتماعي' : 'Social Media' }}
      </h2>

      <div class="flex gap-4">
        <a
          v-if="hasSetting('facebook_url')"
          :href="getSettingContent('facebook_url')"
          target="_blank"
          class="text-blue-600 hover:text-blue-800 text-3xl"
        >
          <i class="fab fa-facebook"></i>
        </a>

        <a
          v-if="hasSetting('twitter_url')"
          :href="getSettingContent('twitter_url')"
          target="_blank"
          class="text-blue-400 hover:text-blue-600 text-3xl"
        >
          <i class="fab fa-twitter"></i>
        </a>

        <a
          v-if="hasSetting('instagram_url')"
          :href="getSettingContent('instagram_url')"
          target="_blank"
          class="text-pink-600 hover:text-pink-800 text-3xl"
        >
          <i class="fab fa-instagram"></i>
        </a>

        <a
          v-if="hasSetting('linkedin_url')"
          :href="getSettingContent('linkedin_url')"
          target="_blank"
          class="text-blue-700 hover:text-blue-900 text-3xl"
        >
          <i class="fab fa-linkedin"></i>
        </a>
      </div>
    </div>

    <!-- Debug Info -->
    <div class="bg-gray-800 text-white p-6 rounded-lg">
      <h2 class="text-xl font-semibold mb-4">Debug Info</h2>

      <div class="space-y-2 text-sm font-mono">
        <p>Current Locale: {{ appStore.locale }}</p>
        <p>Is RTL: {{ appStore.isRTL }}</p>
        <p>Settings Loaded: {{ Object.keys(dataStore.settings).length }}</p>
        <p>Loading: {{ isLoading }}</p>
      </div>

      <div class="mt-4">
        <button
          @click="showSettingsJson = !showSettingsJson"
          class="bg-gray-600 hover:bg-gray-700 px-3 py-1 rounded text-sm"
        >
          {{ showSettingsJson ? 'Hide' : 'Show' }} Settings JSON
        </button>
      </div>

      <pre v-if="showSettingsJson" class="mt-4 bg-gray-900 p-4 rounded overflow-auto max-h-96">
{{ JSON.stringify(dataStore.settings, null, 2) }}
      </pre>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useDataStore } from '../../stores/website-index/dataStore';
import { useAppStore } from '../../stores/website-index/appStore';
import { useWebsiteSettings } from '../../composables/useWebsiteSettings';

const dataStore = useDataStore();
const appStore = useAppStore();
const { getSetting: getSettingFromComposable, hasSetting, isLoading } = useWebsiteSettings();

const showSettingsJson = ref(false);

/**
 * Get setting content based on current locale
 * This is a local helper that works the same as the Footer component
 */
const getSettingContent = (slug: string): string | null => {
  const settings = dataStore.settings as any;
  const setting = settings[slug];

  if (!setting) return null;

  const content = setting.content;

  // Handle multilingual content {ar: "...", en: "..."}
  if (content && typeof content === 'object' && !Array.isArray(content)) {
    const currentLocale = appStore.locale || 'ar';
    return content[currentLocale] || content['ar'] || content['en'] || null;
  }

  // Handle string content
  return content || null;
};
</script>

<style scoped>
/* Add any custom styles here */
</style>

