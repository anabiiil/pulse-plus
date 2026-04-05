<template>
  <div class="flex items-center text-white font-bold justify-center p-4 gap-10 w-full bg-[#03315A]">
    <p class="[direction:ltr]">
      <i class="pi pi-phone text-white mx-2 text-[18px]"></i>
      {{ getSettingContent('phone') || '01555227756 / 01550111555' }}
    </p>
    <p class="[direction:ltr]">
      <i class="pi pi-envelope text-white mx-2 text-[18px]"></i>
      {{ getSettingContent('email') || 'info@pulse-plus.com' }}
    </p>
  </div>
</template>

<script setup lang="ts">
import { useDataStore } from '../../stores/website-index/dataStore';
import { useAppStore } from '../../stores/website-index/appStore';

const dataStore = useDataStore();
const appStore = useAppStore();

/**
 * Get setting content based on current locale
 * Handles both object format {ar: "...", en: "..."} and string format
 */
const getSettingContent = (slug: string): string | null => {
  const settings = dataStore.settings as any;
  const setting = settings[slug];

  if (!setting) return null;

  const content = setting.content;

  // If content is an object with locale keys
  if (content && typeof content === 'object' && !Array.isArray(content)) {
    const currentLocale = appStore.locale || 'ar';
    return content[currentLocale] || content['ar'] || content['en'] || null;
  }

  // If content is a string
  return content || null;
};
</script>

