import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import { useTranslation, type Locale } from '../../locales/website-index';

export const useAppStore = defineStore('website-index-app', () => {
    // State
    const isLoading = ref(true);
    const isDarkMode = ref(false);
    const locale = ref<Locale>('ar');
    const isMobileMenuOpen = ref(false);

    // Getters
    const isRTL = computed(() => locale.value === 'ar');
    const t = computed(() => useTranslation(locale.value).value);

    // Actions
    function setLoading(value: boolean) {
        isLoading.value = value;
    }

    function toggleDarkMode() {
        isDarkMode.value = !isDarkMode.value;
        localStorage.setItem('darkMode', isDarkMode.value.toString());
    }

    function toggleLocale() {
        locale.value = locale.value === 'ar' ? 'en' : 'ar';
        localStorage.setItem('locale', locale.value);

        // Update HTML attributes
        updateHtmlAttributes();
    }

    function updateHtmlAttributes() {
        const html = document.documentElement;
        html.setAttribute('lang', locale.value);
        html.setAttribute('dir', isRTL.value ? 'rtl' : 'ltr');
    }

    function toggleMobileMenu() {
        isMobileMenuOpen.value = !isMobileMenuOpen.value;
    }

    function closeMobileMenu() {
        isMobileMenuOpen.value = false;
    }

    // Initialize from localStorage
    function init() {
        const savedDarkMode = localStorage.getItem('darkMode');
        if (savedDarkMode !== null) {
            isDarkMode.value = savedDarkMode === 'true';
        }

        const savedLocale = localStorage.getItem('locale');
        if (savedLocale && (savedLocale === 'ar' || savedLocale === 'en')) {
            locale.value = savedLocale as Locale;
        }

        // Update HTML attributes on init
        updateHtmlAttributes();

        // Hide loader after initialization
        setTimeout(() => {
            setLoading(false);
        }, 700);
    }

    return {
        // State
        isLoading,
        isDarkMode,
        locale,
        isMobileMenuOpen,
        // Getters
        isRTL,
        t,
        // Actions
        setLoading,
        toggleDarkMode,
        toggleLocale,
        toggleMobileMenu,
        closeMobileMenu,
        updateHtmlAttributes,
        init,
    };
});



