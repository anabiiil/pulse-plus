import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import { useTranslation, type Locale } from '../locales/website';
import { switchLocaleRoute } from '../composables/useLocaleRouter';

export const useWebsiteStore = defineStore('website', () => {
    // State
    const isLoading = ref(true);
    const isDarkMode = ref(false);
    const locale = ref<Locale>('ar');
    const isMobileMenuOpen = ref(false);

    // Router instance will be set when needed
    let routerInstance: any = null;

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

        // Apply dark mode class
        if (isDarkMode.value) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }

    function setLocale(newLocale: Locale) {
        locale.value = newLocale;
        localStorage.setItem('locale', locale.value);
        updateHtmlAttributes();
    }

    function setRouter(router: any) {
        routerInstance = router;
    }

    function toggleLocale() {
        const newLocale = locale.value === 'ar' ? 'en' : 'ar';

        // Get current route path
        const currentPath = routerInstance?.currentRoute?.value?.path || window.location.pathname;
        const newPath = switchLocaleRoute(currentPath, newLocale);

        // Update state first
        setLocale(newLocale);

        // Navigate using Vue Router (no page reload!)
        if (routerInstance) {
            routerInstance.push(newPath);
        } else {
            // Fallback to window navigation if router not available
            window.location.href = newPath;
        }
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
            if (isDarkMode.value) {
                document.documentElement.classList.add('dark');
            }
        }

        // Get locale from route path or localStorage
        const currentPath = window.location.pathname;
        const routeLocale = currentPath.startsWith('/en') ? 'en' : 'ar';

        const savedLocale = localStorage.getItem('locale');
        if (savedLocale && (savedLocale === 'ar' || savedLocale === 'en')) {
            locale.value = savedLocale as Locale;
        } else {
            locale.value = routeLocale;
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
        setLocale,
        setRouter,
        toggleLocale,
        toggleMobileMenu,
        closeMobileMenu,
        updateHtmlAttributes,
        init,
    };
});

