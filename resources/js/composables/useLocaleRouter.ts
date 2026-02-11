import { useRouter, useRoute } from 'vue-router';
import type { Locale } from '../locales/website';

/**
 * Get the localized path for a route
 * Arabic (ar) = no prefix (default)
 * English (en) = /en prefix
 */
export function getLocalizedPath(path: string, locale: Locale): string {
    // Remove any existing locale prefix
    const cleanPath = path.replace(/^\/(en|ar)/, '') || '/';

    // Add locale prefix only for English
    if (locale === 'en') {
        return `/en${cleanPath}`;
    }

    // Arabic is default, no prefix
    return cleanPath;
}

/**
 * Switch between locale routes
 */
export function switchLocaleRoute(currentPath: string, newLocale: Locale): string {
    // Remove existing locale prefix
    const cleanPath = currentPath.replace(/^\/(en|ar)/, '') || '/';

    // Add new locale prefix only for English
    if (newLocale === 'en') {
        return `/en${cleanPath}`;
    }

    // Arabic is default, no prefix
    return cleanPath;
}

/**
 * Composable for locale-aware routing
 */
export function useLocaleRouter() {
    const router = useRouter();
    const route = useRoute();

    /**
     * Navigate to a path with the current or specified locale
     */
    const navigateTo = (path: string, locale?: Locale) => {
        const targetLocale = locale || (route.meta.locale as Locale) || 'ar';
        const localizedPath = getLocalizedPath(path, targetLocale);
        router.push(localizedPath);
    };

    /**
     * Switch to a different locale while staying on the same page
     */
    const switchLocale = (newLocale: Locale) => {
        const newPath = switchLocaleRoute(route.path, newLocale);
        router.push(newPath);
    };

    /**
     * Get the current locale from the route
     */
    const getCurrentLocale = (): Locale => {
        return (route.meta.locale as Locale) || 'ar';
    };

    return {
        navigateTo,
        switchLocale,
        getCurrentLocale,
        getLocalizedPath,
    };
}

