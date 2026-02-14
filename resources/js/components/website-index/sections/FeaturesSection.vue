<template>
  <section id="features" class="py-16 bg-gray-50">
    <div class="max-w-6xl mx-auto text-center mb-12">
      <h2 class="text-3xl font-bold text-gray-800">لماذا تختار Pulse+ ؟</h2>
    </div>

    <div class="max-w-6xl mx-auto grid lg:grid-cols-3 grid-cols-1 gap-8 px-4">
      <div
        v-for="(feature, index) in displayFeatures"
        :key="feature.id || index"
        class="bg-white text-center p-6 rounded-3xl shadow-xl transform transition duration-500 hover:scale-105 hover:shadow-2xl cursor-pointer relative overflow-hidden"
      >
        <div class="flex items-center justify-center">
          <img :src="feature.image_url || feature.icon" class="w-[60px] m-4" :alt="feature.name || feature.title">
        </div>
        <h3 class="text-xl px-10 font-bold mb-2">{{ feature.name || feature.title }}</h3>
        <p class="text-gray-600 text-[14px] font-semibold px-10" v-html="feature.description"></p>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import { useDataStore } from '../../../stores/website-index/dataStore';
import vector1 from '../../../images/website/vector-1.png';
import vector2 from '../../../images/website/vector-2.png';
import vector3 from '../../../images/website/vector-3.png';

interface Feature {
  id?: number;
  name?: string;
  title?: string;
  description: string;
  icon?: string;
  image_url?: string;
}

const dataStore = useDataStore();

// Fallback features if no data from API
const fallbackFeatures: Feature[] = [
  {
    icon: vector1,
    title: 'أمان وخصوصية',
    description: 'تحكم كامل في المعلومات التي تظهر للعموم والمعلومات المخصصة للطوارئ'
  },
  {
    icon: vector2,
    title: 'دعم مرضى الزهايمر ومتلازمة داون',
    description: 'سهولة الوصول لأرقام الطوارئ في حال تاه الشخص أو التعرض لحادث'
  },
  {
    icon: vector3,
    title: 'تقنية NFC و QR',
    description: 'وصول فوري للملف الطبي من خلال لمس السوار بالهاتف أو مسح الرمز'
  }
];

// Use services from store as features, or fallback to static features
const displayFeatures = computed(() => {
  return dataStore.services.length > 0 ? dataStore.services : fallbackFeatures;
});
</script>




