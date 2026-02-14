<template>
    <!-- Footer -->
    <footer class="bg-[#03315A] text-white">
        <div class="max-w-7xl mx-auto px-6 py-10 flex flex-col md:flex-row justify-between gap-8">
            <div class="md:w-1/3 flex justify-center md:justify-start" :class="isRTL ? 'text-center md:text-right' : 'text-center md:text-left'">
                <div class="w-full md:w-auto">
                    <div class="flex justify-center md:justify-start items-center gap-3 mb-3">
                        <img :src="footerLogoImg" class="w-[150px] md:w-[200px]" alt="Pulse Footer Logo">
                    </div>
                    <p class="text-sm">{{ t.footer.description }}</p>
                </div>
            </div>

            <div class="md:w-1/3 flex justify-center">
                <div>
                    <h3 class="font-semibold mb-2" :class="isRTL ? 'text-center md:text-right' : 'text-center md:text-left'">{{ t.footer.quickLinks }}</h3>
                    <ul class="space-y-1 text-sm" :class="isRTL ? 'text-center md:text-right' : 'text-center md:text-left'">
                        <li><a href="/#features" class="hover:text-teal-400 transition-colors">{{ t.nav.services }}</a></li>
                        <li><a href="/#products" class="hover:text-teal-400 transition-colors">{{ t.nav.store }}</a></li>
                        <li><a href="/#features" class="hover:text-teal-400 transition-colors">{{ t.nav.about }}</a></li>
                    </ul>
                </div>
            </div>

            <div class="md:w-1/3 flex justify-center md:justify-end" :class="isRTL ? 'text-center md:text-right' : 'text-center md:text-left'">
                <div>
                    <h3 class="font-semibold mb-2">{{ t.footer.contactUs }}</h3>
                    <p class="text-sm [direction:ltr]">{{ contactInfo.email }}</p>
                    <p class="text-sm [direction:ltr]">{{ contactInfo.phone }}</p>
                    <p class="text-sm mt-1">{{ contactInfo.address }}</p>
                </div>
            </div>
        </div>

        <div class="border-t border-white/20 mt-6 py-4 text-center text-xs text-white/70">
            {{ t.footer.copyright }}
        </div>
    </footer>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import { useWebsiteStore } from '../../stores/websiteStore';
import axios from 'axios';
import footerLogoImg from '../../images/website/footer-logo.png';

const websiteStore = useWebsiteStore();
const t = computed(() => websiteStore.t);
const isRTL = computed(() => websiteStore.isRTL);

const contactInfo = ref({
    phone: '+2 01022335566',
    email: 'info@pulse-plus.com',
    address: websiteStore.locale === 'ar' ? 'القاهرة، جمهورية مصر العربية' : 'Cairo, Arab Republic of Egypt'
});

// Fetch contact information from API
const fetchContactInfo = async () => {
    try {
        const currentLang = websiteStore.locale || 'ar';
        const response = await axios.get('/api/website/contact-info', {
            headers: {
                'Accept-Language': currentLang
            }
        });

        if (response.data.success && response.data.data) {
            contactInfo.value.phone = response.data.data.phone;
            contactInfo.value.email = response.data.data.email;
            contactInfo.value.address = response.data.data.address;
        }
    } catch (error) {
        console.error('Failed to load contact info:', error);
        // Keep default values on error
    }
};

onMounted(() => {
    // Initialize store if not already initialized
    if (!websiteStore.isLoading) {
        websiteStore.init();
    }

    // Fetch dynamic contact information
    fetchContactInfo();
});
</script>

