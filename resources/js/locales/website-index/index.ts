import { computed } from 'vue';
import en from './en';
import ar from './ar';

export type Locale = 'en' | 'ar';

export interface TranslationSchema {
  nav: {
    home: string;
    store: string;
    services: string;
    about: string;
    contact: string;
    login: string;
    darkMode: string;
    language: string;
  };
  footer: {
    description: string;
    quickLinks: string;
    contactUs: string;
    copyright: string;
  };
  common: {
    loading: string;
  };
}

const translations: Record<Locale, TranslationSchema> = {
  en,
  ar,
};

export function useTranslation(locale: Locale) {
  return computed(() => translations[locale]);
}

export { translations };

