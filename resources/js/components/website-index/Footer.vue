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
            <i class="pi pi-envelope mx-1 text-[14px]"></i>
            {{ getSettingContent('email') || 'info@pulse-plus.com' }}
          </p>
          <p class="text-sm" dir="ltr" style="text-align: inherit;">
            <i class="pi pi-phone mx-1 text-[14px]"></i>
            {{ getSettingContent('phone') || '01555227756 / 01550111555' }}
          </p>

          <!-- Social media (only platforms configured from the dashboard) -->
          <div v-if="hasSocials" class="flex items-center justify-center md:justify-end gap-3 mt-4">
            <a v-if="socialLink('facebook')" :href="socialLink('facebook')!" target="_blank" rel="noopener" aria-label="Facebook"
               class="w-9 h-9 rounded-full bg-white/10 hover:bg-teal-500 flex items-center justify-center transition-colors">
              <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M22 12a10 10 0 1 0-11.56 9.88v-6.99H7.9V12h2.54V9.8c0-2.5 1.49-3.89 3.77-3.89 1.09 0 2.24.2 2.24.2v2.46h-1.26c-1.24 0-1.63.77-1.63 1.56V12h2.78l-.44 2.89h-2.34v6.99A10 10 0 0 0 22 12Z"/></svg>
            </a>
            <a v-if="socialLink('instagram')" :href="socialLink('instagram')!" target="_blank" rel="noopener" aria-label="Instagram"
               class="w-9 h-9 rounded-full bg-white/10 hover:bg-teal-500 flex items-center justify-center transition-colors">
              <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 2.16c3.2 0 3.58.01 4.85.07 1.17.05 1.8.25 2.23.41.56.22.96.48 1.38.9.42.42.68.82.9 1.38.16.42.36 1.06.41 2.23.06 1.27.07 1.65.07 4.85s-.01 3.58-.07 4.85c-.05 1.17-.25 1.8-.41 2.23-.22.56-.48.96-.9 1.38-.42.42-.82.68-1.38.9-.42.16-1.06.36-2.23.41-1.27.06-1.65.07-4.85.07s-3.58-.01-4.85-.07c-1.17-.05-1.8-.25-2.23-.41a3.7 3.7 0 0 1-1.38-.9 3.7 3.7 0 0 1-.9-1.38c-.16-.42-.36-1.06-.41-2.23C2.17 15.58 2.16 15.2 2.16 12s.01-3.58.07-4.85c.05-1.17.25-1.8.41-2.23.22-.56.48-.96.9-1.38.42-.42.82-.68 1.38-.9.42-.16 1.06-.36 2.23-.41C8.42 2.17 8.8 2.16 12 2.16Zm0 1.62c-3.15 0-3.52.01-4.76.07-.9.04-1.39.19-1.71.32-.43.17-.74.37-1.06.69-.32.32-.52.63-.69 1.06-.13.32-.28.81-.32 1.71-.06 1.24-.07 1.61-.07 4.76s.01 3.52.07 4.76c.04.9.19 1.39.32 1.71.17.43.37.74.69 1.06.32.32.63.52 1.06.69.32.13.81.28 1.71.32 1.24.06 1.61.07 4.76.07s3.52-.01 4.76-.07c.9-.04 1.39-.19 1.71-.32.43-.17.74-.37 1.06-.69.32-.32.52-.63.69-1.06.13-.32.28-.81.32-1.71.06-1.24.07-1.61.07-4.76s-.01-3.52-.07-4.76c-.04-.9-.19-1.39-.32-1.71a2.85 2.85 0 0 0-.69-1.06 2.85 2.85 0 0 0-1.06-.69c-.32-.13-.81-.28-1.71-.32-1.24-.06-1.61-.07-4.76-.07Zm0 2.76a5.3 5.3 0 1 1 0 10.6 5.3 5.3 0 0 1 0-10.6Zm0 1.62a3.68 3.68 0 1 0 0 7.36 3.68 3.68 0 0 0 0-7.36Zm5.5-2.9a1.24 1.24 0 1 1 0 2.48 1.24 1.24 0 0 1 0-2.48Z"/></svg>
            </a>
            <a v-if="socialLink('twitter')" :href="socialLink('twitter')!" target="_blank" rel="noopener" aria-label="X"
               class="w-9 h-9 rounded-full bg-white/10 hover:bg-teal-500 flex items-center justify-center transition-colors">
              <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M18.24 2.25h3.31l-7.23 8.26 8.5 11.24h-6.65l-5.22-6.82-5.96 6.82H1.68l7.73-8.84L1.25 2.25h6.82l4.71 6.23 5.46-6.23Zm-1.16 17.52h1.83L7.01 4.13H5.05l12.03 15.64Z"/></svg>
            </a>
            <a v-if="socialLink('tiktok')" :href="socialLink('tiktok')!" target="_blank" rel="noopener" aria-label="TikTok"
               class="w-9 h-9 rounded-full bg-white/10 hover:bg-teal-500 flex items-center justify-center transition-colors">
              <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M16.5 3c.3 2.06 1.46 3.29 3.5 3.42v2.36c-1.18.12-2.21-.27-3.42-.99v4.4c0 5.6-6.1 7.35-8.55 3.34-1.57-2.58-.6-7.1 4.47-7.28v2.49c-.39.06-.8.16-1.18.29-1.13.38-1.77 1.1-1.59 2.36.34 2.42 4.78 3.13 4.41-1.6V3h1.87Z"/></svg>
            </a>
            <a v-if="socialLink('whatsapp')" :href="socialLink('whatsapp')!" target="_blank" rel="noopener" aria-label="WhatsApp"
               class="w-9 h-9 rounded-full bg-white/10 hover:bg-teal-500 flex items-center justify-center transition-colors">
              <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2 22l5.25-1.38a9.9 9.9 0 0 0 4.79 1.22h.01c5.46 0 9.91-4.45 9.91-9.91C21.96 6.45 17.5 2 12.04 2Zm0 18.15h-.01a8.2 8.2 0 0 1-4.19-1.15l-.3-.18-3.12.82.83-3.04-.2-.31a8.24 8.24 0 0 1-1.26-4.38c0-4.54 3.7-8.24 8.25-8.24 2.2 0 4.27.86 5.83 2.42a8.2 8.2 0 0 1 2.41 5.83c0 4.55-3.7 8.24-8.25 8.24Zm4.52-6.17c-.25-.12-1.47-.72-1.69-.81-.23-.08-.39-.12-.56.13-.16.25-.64.81-.79.97-.14.17-.29.19-.54.06-.25-.12-1.05-.39-1.99-1.23-.74-.66-1.23-1.47-1.38-1.72-.14-.25-.01-.38.11-.51.11-.11.25-.29.37-.43.13-.14.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.12-.56-1.34-.76-1.84-.2-.48-.4-.42-.56-.43h-.48c-.17 0-.43.06-.66.31-.23.25-.86.85-.86 2.07 0 1.22.89 2.4 1.01 2.56.12.17 1.75 2.67 4.23 3.74.59.26 1.05.41 1.41.52.59.19 1.13.16 1.56.1.48-.07 1.47-.6 1.67-1.18.21-.58.21-1.07.14-1.18-.06-.11-.22-.17-.47-.29Z"/></svg>
            </a>
          </div>
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
import { computed } from 'vue';
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

/**
 * Build a usable href for a social platform, or null when it's not configured.
 * WhatsApp accepts a bare phone number and is turned into a wa.me link.
 */
const socialLink = (slug: string): string | null => {
  const raw = getSettingContent(slug);
  if (!raw) return null;

  const value = String(raw).trim();
  if (!value) return null;

  if (slug === 'whatsapp') {
    if (/^https?:\/\//i.test(value)) return value;
    let digits = value.replace(/[^\d]/g, '');
    if (!digits) return null;
    // Local Egyptian number (leading 0) -> international format for wa.me
    if (digits.startsWith('0')) digits = '20' + digits.slice(1);
    return `https://wa.me/${digits}`;
  }

  return /^https?:\/\//i.test(value) ? value : `https://${value}`;
};

const hasSocials = computed(() =>
  ['facebook', 'instagram', 'twitter', 'tiktok', 'whatsapp'].some((slug) => socialLink(slug))
);
</script>





