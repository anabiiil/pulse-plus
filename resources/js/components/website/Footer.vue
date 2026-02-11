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
                    <p class="text-sm">info@pulse-plus.com</p>
                    <p class="text-sm">+2 01022335566</p>
                </div>
            </div>
        </div>

        <div class="border-t border-white/20 mt-6 py-4 text-center text-xs text-white/70">
            {{ t.footer.copyright }}
        </div>
    </footer>
</template>

<script setup lang="ts">
import { computed, onMounted } from 'vue';
import { useWebsiteStore } from '../../stores/websiteStore';
import footerLogoImg from '../../images/website/footer-logo.png';

const websiteStore = useWebsiteStore();
const t = computed(() => websiteStore.t);
const isRTL = computed(() => websiteStore.isRTL);

onMounted(() => {
    // Initialize store if not already initialized
    if (!websiteStore.isLoading) {
        websiteStore.init();
    }
});
</script>

