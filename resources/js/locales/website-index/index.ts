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
    allTitle: string;
    empty: string;
    prev: string;
    next: string;
    viewAll: string;
  };
  productDetail: {
    back: string;
    price: string;
    playVideo: string;
    description: string;
    notFound: string;
    loadError: string;
    related: string;
    home: string;
  };
  cart: {
    title: string;
    empty: string;
    addToCart: string;
    updateCart: string;
    updated: string;
    added: string;
    quantity: string;
    remove: string;
    clear: string;
    subtotal: string;
    total: string;
    checkout: string;
    continueShopping: string;
    viewCart: string;
    loginRequired: string;
    itemsCount: string;
    currency: string;
  };
  checkout: {
    title: string;
    customerName: string;
    phone: string;
    address: string;
    addressPlaceholder: string;
    governorate: string;
    selectGovernorate: string;
    notes: string;
    notesPlaceholder: string;
    orderSummary: string;
    shipping: string;
    subtotal: string;
    total: string;
    paymentMethod: string;
    selectPayment: string;
    receipt: string;
    receiptHint: string;
    placeOrder: string;
    placing: string;
    success: string;
    emptyCart: string;
    selectGovFirst: string;
    successTitle: string;
    successHint: string;
    orderNo: string;
    viewOrders: string;
  };
  orders: {
    title: string;
    empty: string;
    orderNumber: string;
    date: string;
    status: string;
    total: string;
    viewDetails: string;
    details: string;
    items: string;
    product: string;
    price: string;
    quantity: string;
    lineTotal: string;
    shippingInfo: string;
    shipping: string;
    subtotal: string;
    back: string;
    myOrders: string;
    statuses: {
      pending: string;
      confirmed: string;
      in_progress: string;
      on_way: string;
      completed: string;
      canceled: string;
      canceled_by_client: string;
    };
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

