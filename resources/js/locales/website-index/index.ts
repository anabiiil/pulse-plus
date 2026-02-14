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
    profile: string;
    logout: string;
    darkMode: string;
    language: string;
  };
  footer: {
    description: string;
    quickLinks: string;
    contactUs: string;
    copyright: string;
  };
  products: {
    title: string;
    currency: string;
  };
  features: {
    title: string;
  };
  profile: {
    title: string;
    profileCompletion: string;
    personalInfo: {
      title: string;
      subtitle: string;
    };
    medicalData: {
      title: string;
      subtitle: string;
    };
    medicalArchive: {
      title: string;
      subtitle: string;
    };
    securityNotice: {
      title: string;
      description: string;
    };
    form: {
      whoAreYou: string;
      whoAreYouSubtitle: string;
      profileImage: string;
      profileImageDesc: string;
      fullName: string;
      fullNamePlaceholder: string;
      birthdate: string;
      gender: string;
      male: string;
      female: string;
      phone: string;
      phonePlaceholder: string;
      emergencyPhone: string;
      emergencyPhonePlaceholder: string;
      address: string;
      addressPlaceholder: string;
      email: string;
      emailPlaceholder: string;
      nationality: string;
      selectNationality: string;
      maritalStatus: string;
      selectMaritalStatus: string;
      saveChanges: string;
      saving: string;
      cancelChanges: string;
    };
    messages: {
      successUpdate: string;
      errorUpdate: string;
      errorLoad: string;
    };
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

