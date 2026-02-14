import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import { useTranslation, type Locale } from '../../locales/website-index';
import { switchLocaleRoute } from '../../composables/useLocaleRouter';

export const useAppStore = defineStore('website-index-app', () => {
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
        locale.value = newLocale;
        localStorage.setItem('locale', newLocale);
        updateHtmlAttributes();

        // Use full page reload to ensure translations update correctly
        window.location.href = newPath;
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

    async function scrollToSection(sectionId: string) {
        // Close mobile menu if open
        closeMobileMenu();

        // Get current route
        const currentPath = routerInstance?.currentRoute?.value?.path || window.location.pathname;

        // Check if we're on the home page
        const isHome = currentPath === '/' || currentPath === '/en';

        if (!isHome) {
            // Navigate to home page first
            const homePath = locale.value === 'en' ? '/en' : '/';

            if (routerInstance) {
                await routerInstance.push(homePath);
                // Wait for navigation and DOM update
                await new Promise(resolve => setTimeout(resolve, 100));
            } else {
                window.location.href = homePath + '#' + sectionId;
                return;
            }
        }

        // Scroll to section
        const element = document.getElementById(sectionId);
        if (element) {
            element.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    // Initialize from localStorage
    function init() {
        const savedDarkMode = localStorage.getItem('darkMode');
        if (savedDarkMode !== null) {
            isDarkMode.value = savedDarkMode === 'true';
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
        setRouter,
        toggleLocale,
        toggleMobileMenu,
        closeMobileMenu,
        scrollToSection,
        updateHtmlAttributes,
        init,
    };
});



