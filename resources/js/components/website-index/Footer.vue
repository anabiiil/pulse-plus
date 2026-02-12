<template>
  <footer class="bg-[#03315A] text-white">
    <div class="max-w-7xl mx-auto px-6 py-10 flex flex-col md:flex-row justify-between gap-8">
      <!-- About Section -->
      <div class="md:w-1/3 flex justify-center md:justify-start text-center md:text-right">
        <div class="w-full md:w-auto">
          <div class="flex justify-center md:justify-start items-center gap-3 mb-3">
            <img :src="footerLogo" class="w-[150px] md:w-[200px]" alt="Pulse Logo">
          </div>
          <!-- Display footer description from settings if available, otherwise use translation -->
          <p class="text-sm">
            {{ getSettingContent('footer_description') || appStore.t.footer.description }}
          </p>
        </div>
      </div>

      <!-- Quick Links -->
      <div class="md:w-1/3 flex justify-center">
        <div>
          <h3 class="font-semibold mb-2 text-center md:text-left">{{ appStore.t.footer.quickLinks }}</h3>
          <ul class="space-y-1 text-sm text-center md:text-left">
            <li><a href="#features" class="hover:text-teal-400 transition-colors">{{ appStore.t.nav.services }}</a></li>
            <li><a href="#products" class="hover:text-teal-400 transition-colors">{{ appStore.t.nav.store }}</a></li>
            <li><a href="#about" class="hover:text-teal-400 transition-colors">{{ appStore.t.nav.about }}</a></li>
          </ul>
        </div>
      </div>

      <!-- Contact Info -->
      <div class="md:w-1/3 flex justify-center md:justify-end text-center md:text-right">
        <div>
          <h3 class="font-semibold mb-2">{{ appStore.t.footer.contactUs }}</h3>
          <!-- Email and Phone with LTR direction -->
          <p class="text-sm" dir="ltr" style="text-align: inherit;">
            {{ getSettingContent('contact_email') || 'info@pulse-plus.com' }}
          </p>
          <p class="text-sm" dir="ltr" style="text-align: inherit;">
            {{ getSettingContent('contact_phone') || '+2 01022335566' }}
          </p>
        </div>
      </div>
    </div>

    <!-- Copyright -->
    <div class="border-t border-white/20 mt-6 py-4 text-center text-xs text-white/70">
      {{ appStore.t.footer.copyright }}
    </div>
  </footer>
</template>

<script setup lang="ts">
import { useDataStore } from '../../stores/website-index/dataStore';
import { useAppStore } from '../../stores/website-index/appStore';
import footerLogo from '../../images/website/footer-logo.png';

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





