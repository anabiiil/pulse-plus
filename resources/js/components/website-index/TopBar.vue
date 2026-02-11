<template>
  <div class="flex items-center text-white font-bold justify-center p-4 gap-10 w-full bg-[#03315A]">
    <p class="[direction:ltr]">
      <i class="pi pi-phone text-white mx-2 text-[18px]"></i> {{ dataStore.settings.phone }}
    </p>
    <p class="[direction:ltr]">
      <i class="pi pi-envelope text-white mx-2 text-[18px]"></i> {{ dataStore.settings.email }}
    </p>
  </div>
</template>

<script setup lang="ts">
import { useDataStore } from '../../stores/website-index/dataStore';

const dataStore = useDataStore();
</script>

