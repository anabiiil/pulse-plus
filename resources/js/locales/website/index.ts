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
  login: {
    title: string;
    subtitle: string;
    email: string;
    password: string;
    emailPlaceholder: string;
    passwordPlaceholder: string;
    forgotPassword: string;
    loginButton: string;
    successMessage: string;
    errorMessage: string;
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
  contact: {
    title: string;
    subtitle: string;
    form: {
      name: string;
      namePlaceholder: string;
      email: string;
      emailPlaceholder: string;
      subject: string;
      subjectPlaceholder: string;
      message: string;
      messagePlaceholder: string;
      submit: string;
      sending: string;
      sendMessage: string;
    };
    info: {
      phone: string;
      email: string;
      location: string;
      address: string;
    };
    premiumService: {
      title: string;
      description: string;
      button: string;
    };
    messages: {
      success: string;
      error: string;
      validationError: string;
      nameRequired: string;
      emailRequired: string;
      emailInvalid: string;
      subjectRequired: string;
      messageRequired: string;
      messageTooLong: string;
    };
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
  userInfo: {
    title: string;
    loading: string;
    error: string;
    userNotFound: string;
    errorLoading: string;
    invalidLink: string;
    backToHome: string;
    emergencyProfile: string;
    personalInfo: string;
    medicalInfo: string;
    fullName: string;
    birthdate: string;
    gender: string;
    maritalStatus: string;
    address: string;
    phoneNumber: string;
    email: string;
    nationality: string;
    emergencyPhone: string;
    bloodType: string;
    allergies: string;
    medications: string;
    medicalNotes: string;
    diseases: string;
    chronicDiseasesAllergies: string;
    otherMedicalNotes: string;
    callEmergency: string;
    callEmergencyNumber: string;
    emergencyNotice: string;
    disclaimer: string;
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

