import { computed } from 'vue';
import { useDataStore } from '../stores/website-index/dataStore';
import { useAppStore } from '../stores/website-index/appStore';

interface Setting {
    id: number;
    title: string | object | null;
    content: any;
}

interface Settings {
    [slug: string]: Setting;
}

/**
 * Composable for accessing website settings in Vue components
 * Settings are loaded globally and available throughout the application
 */
export const useWebsiteSettings = () => {
    const dataStore = useDataStore();
    const appStore = useAppStore();

    // Get all settings
    const settings = computed<Settings>(() => dataStore.settings as Settings);

    // Get loading state
    const isLoading = computed(() => dataStore.isDataLoading);

    /**
     * Get a specific setting by slug
     * @param slug - The slug of the setting
     * @param field - The field to get (content, title, or entire object)
     * @returns The setting value or null if not found
     */
    const getSetting = (slug: string, field: 'content' | 'title' | 'all' = 'content') => {
        const setting = settings.value[slug] as Setting | undefined;

        if (!setting) return null;

        if (field === 'all') return setting;

        const data = field === 'content' ? setting.content : setting.title;

        // Handle multilingual content/title (object with locale keys)
        if (data && typeof data === 'object' && !Array.isArray(data)) {
            const currentLocale = appStore.locale || 'ar';
            return data[currentLocale] || data['ar'] || data['en'] || null;
        }

        // Return string value
        return data || null;
    };

    /**
     * Check if a setting exists
     */
    const hasSetting = (slug: string): boolean => {
        return !!settings.value[slug];
    };

    /**
     * Reload settings from the API
     */
    const refreshSettings = async () => {
        await dataStore.fetchSettings();
    };

    return {
        // State
        settings,
        isLoading,
        // Methods
        getSetting,
        hasSetting,
        refreshSettings,
    };
};


