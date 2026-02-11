<template>
  <footer class="bg-[#03315A] text-white">
    <div class="max-w-7xl mx-auto px-6 py-10 flex flex-col md:flex-row justify-between gap-8">
      <!-- About Section -->
      <div class="md:w-1/3 flex justify-center md:justify-start text-center md:text-right">
        <div class="w-full md:w-auto">
          <div class="flex justify-center md:justify-start items-center gap-3 mb-3">
            <img :src="footerLogo" class="w-[150px] md:w-[200px]" alt="Pulse Logo">
          </div>
          <p class="text-sm">
            نحن نؤمن أن التكنولوجيا يجب أن تخدم الإنسانية، خصوصاً في لحظات الضغف والقوة
          </p>
        </div>
      </div>

      <!-- Quick Links -->
      <div class="md:w-1/3 flex justify-center">
        <div>
          <h3 class="font-semibold mb-2 text-center md:text-left">روابط سريعة</h3>
          <ul class="space-y-1 text-sm text-center md:text-left">
            <li><a href="#features" class="hover:text-teal-400 transition-colors">خدماتنا</a></li>
            <li><a href="#products" class="hover:text-teal-400 transition-colors">المتجر</a></li>
            <li><a href="#about" class="hover:text-teal-400 transition-colors">من نحن</a></li>
          </ul>
        </div>
      </div>

      <!-- Contact Info -->
      <div class="md:w-1/3 flex justify-center md:justify-end text-center md:text-right">
        <div>
          <h3 class="font-semibold mb-2">تواصل معنا</h3>
          <p class="text-sm">{{ dataStore.settings.email }}</p>
          <p class="text-sm">{{ dataStore.settings.phone }}</p>
        </div>
      </div>
    </div>

    <!-- Copyright -->
    <div class="border-t border-white/20 mt-6 py-4 text-center text-xs text-white/70">
      © 2024 Pulse+ جميع الحقوق محفوظة
    </div>
  </footer>
</template>

<script setup lang="ts">
import { useDataStore } from '../../stores/website-index/dataStore';
import footerLogo from '../../images/website/footer-logo.png';

const dataStore = useDataStore();
</script>





