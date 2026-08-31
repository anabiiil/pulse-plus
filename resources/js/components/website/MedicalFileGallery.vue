<template>
    <div>
        <!-- Images grouped into a small slider -->
        <div v-if="images.length" class="mt-3">
            <div class="relative w-full max-w-[260px] rounded-2xl overflow-hidden border border-gray-200 bg-gray-50">
                <button type="button" @click="openLightbox(current)" class="block w-full cursor-zoom-in">
                    <img
                        :src="images[current].file_url"
                        :alt="images[current].original_name || 'image'"
                        class="w-full h-40 object-cover"
                    >
                </button>

                <!-- Prev / Next -->
                <template v-if="images.length > 1">
                    <button
                        type="button"
                        @click.stop="prev"
                        class="absolute top-1/2 -translate-y-1/2 start-1.5 w-7 h-7 rounded-full bg-white/85 shadow flex items-center justify-center text-[#123057] hover:bg-white transition"
                        aria-label="Previous"
                    >
                        <i class="pi pi-chevron-right rtl-flip text-xs"></i>
                    </button>
                    <button
                        type="button"
                        @click.stop="next"
                        class="absolute top-1/2 -translate-y-1/2 end-1.5 w-7 h-7 rounded-full bg-white/85 shadow flex items-center justify-center text-[#123057] hover:bg-white transition"
                        aria-label="Next"
                    >
                        <i class="pi pi-chevron-left rtl-flip text-xs"></i>
                    </button>
                </template>

                <!-- Counter -->
                <span v-if="images.length > 1" class="absolute bottom-1.5 end-1.5 bg-black/55 text-white text-[10px] font-semibold px-2 py-0.5 rounded-full">
                    {{ current + 1 }} / {{ images.length }}
                </span>

                <!-- Print current image -->
                <button
                    type="button"
                    @click.stop="printFile(images[current].file_url)"
                    class="absolute top-1.5 end-1.5 w-7 h-7 rounded-full bg-teal-500/90 text-white items-center justify-center hover:bg-teal-600 transition"
                    :class="hidePrintOnMobile ? 'hidden sm:flex' : 'flex'"
                    :title="printLabel"
                >
                    <i class="pi pi-print text-[11px]"></i>
                </button>
            </div>

            <!-- Dots -->
            <div v-if="images.length > 1" class="flex items-center gap-1.5 mt-2">
                <button
                    v-for="(img, i) in images"
                    :key="img.id || i"
                    type="button"
                    @click="current = i"
                    class="w-2 h-2 rounded-full transition"
                    :class="i === current ? 'bg-teal-500' : 'bg-gray-300 hover:bg-gray-400'"
                    :aria-label="`Go to image ${i + 1}`"
                ></button>
            </div>
        </div>

        <!-- Non-image files, listed separately below -->
        <div v-if="files.length" class="mt-3 flex flex-wrap gap-2">
            <div
                v-for="(f, i) in files"
                :key="f.id || `file-${i}`"
                class="inline-flex items-center gap-1.5 bg-white border border-gray-200 rounded-full ps-3 pe-1.5 py-1 text-xs"
            >
                <a :href="f.file_url" target="_blank" class="inline-flex items-center gap-1.5 text-[#123057] hover:text-teal-600 transition">
                    <i class="pi pi-file-pdf text-red-400 text-[12px]"></i>
                    <span class="max-w-[120px] truncate">{{ f.original_name || fileLabel(i) }}</span>
                </a>
                <button
                    type="button"
                    @click="printFile(f.file_url)"
                    class="w-6 h-6 rounded-full bg-teal-100 text-teal-600 items-center justify-center hover:bg-teal-200 transition"
                    :class="hidePrintOnMobile ? 'hidden sm:flex' : 'flex'"
                    :title="printLabel"
                >
                    <i class="pi pi-print text-[11px]"></i>
                </button>
            </div>
        </div>

        <!-- Lightbox -->
        <Teleport to="body">
            <div
                v-if="lightboxOpen"
                class="fixed inset-0 z-[100] flex items-center justify-center bg-black/85 p-4"
                @click.self="closeLightbox"
            >
                <!-- Close -->
                <button
                    type="button"
                    @click="closeLightbox"
                    class="absolute top-4 end-4 w-11 h-11 rounded-full bg-white/15 text-white flex items-center justify-center hover:bg-white/25 transition"
                    aria-label="Close"
                >
                    <i class="pi pi-times text-lg"></i>
                </button>

                <!-- Prev -->
                <button
                    v-if="images.length > 1"
                    type="button"
                    @click.stop="prev"
                    class="absolute start-3 sm:start-6 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white/15 text-white flex items-center justify-center hover:bg-white/25 transition"
                    aria-label="Previous"
                >
                    <i class="pi pi-chevron-right rtl-flip text-xl"></i>
                </button>

                <!-- Image -->
                <img
                    :src="images[current].file_url"
                    :alt="images[current].original_name || 'image'"
                    class="max-w-[92vw] max-h-[85vh] object-contain rounded-lg shadow-2xl select-none"
                >

                <!-- Next -->
                <button
                    v-if="images.length > 1"
                    type="button"
                    @click.stop="next"
                    class="absolute end-3 sm:end-6 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white/15 text-white flex items-center justify-center hover:bg-white/25 transition"
                    aria-label="Next"
                >
                    <i class="pi pi-chevron-left rtl-flip text-xl"></i>
                </button>

                <!-- Counter -->
                <span v-if="images.length > 1" class="absolute bottom-5 left-1/2 -translate-x-1/2 bg-white/15 text-white text-sm font-semibold px-4 py-1.5 rounded-full">
                    {{ current + 1 }} / {{ images.length }}
                </span>
            </div>
        </Teleport>
    </div>
</template>

<script setup lang="ts">
import { computed, onBeforeUnmount, ref } from 'vue';

interface Attachment {
    id?: number;
    file_url: string;
    original_name?: string;
}

const props = withDefaults(defineProps<{
    attachments: Attachment[];
    hidePrintOnMobile?: boolean;
    rtl?: boolean;
}>(), {
    hidePrintOnMobile: false,
    rtl: true,
});

const isImage = (url: string): boolean => /\.(jpg|jpeg|png|gif|webp)(\?|$)/i.test(url || '');

const images = computed(() => props.attachments.filter((a) => isImage(a.file_url)));
const files = computed(() => props.attachments.filter((a) => !isImage(a.file_url)));

const current = ref(0);

const next = (): void => {
    if (images.value.length) {
        current.value = (current.value + 1) % images.value.length;
    }
};

const prev = (): void => {
    if (images.value.length) {
        current.value = (current.value - 1 + images.value.length) % images.value.length;
    }
};

const printLabel = computed(() => (props.rtl ? 'طباعة' : 'Print'));
const fileLabel = (i: number): string => (props.rtl ? `ملف ${i + 1}` : `File ${i + 1}`);

// Lightbox (enlarged image with left/right navigation)
const lightboxOpen = ref(false);

const onKeydown = (e: KeyboardEvent): void => {
    if (!lightboxOpen.value) { return; }
    if (e.key === 'Escape') { closeLightbox(); }
    else if (e.key === 'ArrowRight') { next(); }
    else if (e.key === 'ArrowLeft') { prev(); }
};

const openLightbox = (i: number): void => {
    current.value = i;
    lightboxOpen.value = true;
    document.body.style.overflow = 'hidden';
    window.addEventListener('keydown', onKeydown);
};

const closeLightbox = (): void => {
    lightboxOpen.value = false;
    document.body.style.overflow = '';
    window.removeEventListener('keydown', onKeydown);
};

onBeforeUnmount(() => {
    document.body.style.overflow = '';
    window.removeEventListener('keydown', onKeydown);
});

/**
 * Open a file (image or PDF) in a hidden iframe and print it directly.
 */
const printFile = (url: string): void => {
    if (!url) { return; }

    const existing = document.getElementById('gallery-print-frame');
    if (existing) { existing.remove(); }

    const iframe = document.createElement('iframe');
    iframe.id = 'gallery-print-frame';
    iframe.style.cssText = 'position:fixed;right:0;bottom:0;width:0;height:0;border:0;';
    document.body.appendChild(iframe);

    const cleanup = (): void => { setTimeout(() => iframe.remove(), 500); };

    if (isImage(url)) {
        const doc = iframe.contentWindow?.document;
        if (!doc) { return; }
        doc.open();
        doc.write(`<!DOCTYPE html><html><head><meta charset="utf-8"><style>@page{margin:10mm}html,body{margin:0;height:100%}body{display:flex;align-items:center;justify-content:center}img{max-width:100%;max-height:100vh}</style></head><body><img src="${url}" onload="window.focus();window.print();"></body></html>`);
        doc.close();
        iframe.contentWindow?.addEventListener('afterprint', cleanup);
    } else {
        iframe.onload = () => {
            try {
                iframe.contentWindow?.focus();
                iframe.contentWindow?.print();
                iframe.contentWindow?.addEventListener('afterprint', cleanup);
            } catch (e) {
                console.error('Print failed', e);
            }
        };
        iframe.src = url;
    }

    setTimeout(() => iframe.remove(), 60000);
};
</script>

<style scoped>
[dir='rtl'] .rtl-flip {
    transform: scaleX(-1);
}
</style>
