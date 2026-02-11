import { defineStore } from 'pinia';
import { ref, computed } from 'vue';

export const useAppStore = defineStore('website-index-app', () => {
    // State
    const isLoading = ref(true);
    const isDarkMode = ref(false);
    const locale = ref('ar');
    const isMobileMenuOpen = ref(false);

    // Getters
    const isRTL = computed(() => locale.value === 'ar');

    // Actions
    function setLoading(value: boolean) {
        isLoading.value = value;
    }

    function toggleDarkMode() {
        isDarkMode.value = !isDarkMode.value;
        // You can add localStorage persistence here
        localStorage.setItem('darkMode', isDarkMode.value.toString());
    }

    function toggleLocale() {
        locale.value = locale.value === 'ar' ? 'en' : 'ar';
        localStorage.setItem('locale', locale.value);
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
        if (savedLocale) {
            locale.value = savedLocale;
        }

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
        // Actions
        setLoading,
        toggleDarkMode,
        toggleLocale,
        toggleMobileMenu,
        closeMobileMenu,
        init,
    };
});

