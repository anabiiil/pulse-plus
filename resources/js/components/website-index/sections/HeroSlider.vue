<template>
  <section v-if="slides.length > 0" class="w-full h-[70vh]">
    <div class="swiper mySwiper w-full h-full">
      <div class="swiper-wrapper">
        <div
          v-for="(slide, index) in slides"
          :key="index"
          class="swiper-slide relative"
        >
          <img
            :src="slide.image_url || slide.image"
            class="w-full h-full object-cover"
            :alt="slide.title"
          />
          <div class="absolute inset-0 flex items-end justify-start [direction:ltr]">
            <div class="hidden lg:block px-20 pb-20 max-w-xl">
              <h2 class="text-5xl font-extrabold text-black mb-4">
                {{ slide.title }}
              </h2>
              <p class="text-gray-600 text-lg mb-6">
                {{ slide.description }}
              </p>
            </div>
          </div>
        </div>
      </div>
      <div class="swiper-pagination"></div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted, watch, nextTick } from 'vue';
import { useDataStore } from '../../../stores/website-index/dataStore';
import Swiper from 'swiper';
import { Pagination, Autoplay } from 'swiper/modules';
import slideImg from '../../../images/website/slide.png';

const dataStore = useDataStore();

// Fallback slides if no data from API
const fallbackSlides = [
  {
    image: slideImg,
    title: 'NFC WRISTBAND',
    description: 'Your digital business card, on your wrist with the latest NFC technology'
  },
  {
    image: slideImg,
    title: 'NFC WRISTBAND',
    description: 'Your digital business card, on your wrist with the latest NFC technology'
  },
  {
    image: slideImg,
    title: 'NFC WRISTBAND',
    description: 'Your digital business card, on your wrist with the latest NFC technology'
  }
];

// Use sliders from store, or fallback to static slides
const slides = computed(() => {
  return dataStore.sliders.length > 0 ? dataStore.sliders : fallbackSlides;
});

let swiper: Swiper | null = null;

const initSwiper = () => {
  nextTick(() => {
    if (swiper) {
      swiper.destroy(true, true);
    }

    swiper = new Swiper('.mySwiper', {
      modules: [Pagination, Autoplay],
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      autoplay: slides.value.length > 1 ? {
        delay: 5000,
        disableOnInteraction: false,
      } : false,
      loop: slides.value.length > 1,
    });
  });
};

onMounted(() => {
  initSwiper();
});

// Reinitialize swiper when slides change
watch(() => dataStore.sliders, () => {
  if (dataStore.sliders.length > 0) {
    initSwiper();
  }
}, { deep: true });

onUnmounted(() => {
  if (swiper) {
    swiper.destroy();
  }
});
</script>




