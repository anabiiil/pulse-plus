<template>
  <div class="relative" ref="root">
    <!-- Trigger (styled identically to the form inputs) -->
    <div
      class="w-full flex items-center justify-between gap-2 border rounded-xl px-4 py-3 bg-white cursor-pointer transition"
      :class="invalid ? 'border-red-400' : (open ? 'border-teal-500' : 'border-gray-200')"
      @click="toggle"
    >
      <span :class="selectedLabel ? 'text-gray-800' : 'text-gray-400'" class="truncate">
        {{ selectedLabel || placeholder }}
      </span>
      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400 flex-shrink-0 transition-transform" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
      </svg>
    </div>

    <!-- Dropdown -->
    <div v-if="open" class="absolute z-50 mt-2 w-full bg-white rounded-xl shadow-2xl border border-gray-100 overflow-hidden">
      <div class="p-2 border-b border-gray-100">
        <input
          ref="searchInput"
          v-model="search"
          type="text"
          :placeholder="searchPlaceholder"
          class="w-full px-3 py-2 border border-gray-200 rounded-lg outline-none focus:border-teal-500 text-sm"
          @keydown.escape="open = false"
        >
      </div>
      <ul class="max-h-60 overflow-y-auto py-1">
        <li
          v-for="opt in filtered"
          :key="opt.value"
          class="px-4 py-2.5 cursor-pointer hover:bg-teal-50 transition text-sm"
          :class="{ 'bg-teal-50 text-teal-700 font-semibold': opt.value === modelValue }"
          @click="choose(opt)"
        >
          {{ opt.label }}
        </li>
        <li v-if="!filtered.length" class="px-4 py-3 text-gray-400 text-sm text-center">
          {{ noResultsText }}
        </li>
      </ul>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed, nextTick, onMounted, onUnmounted, ref } from 'vue';

interface Option {
  value: number | string;
  label: string;
}

const props = withDefaults(defineProps<{
  modelValue: number | string | null;
  options: Option[];
  placeholder?: string;
  searchPlaceholder?: string;
  noResultsText?: string;
  invalid?: boolean;
}>(), {
  placeholder: 'Select...',
  searchPlaceholder: 'Search...',
  noResultsText: 'No results found',
  invalid: false,
});

const emit = defineEmits<{ 'update:modelValue': [value: number | string | null] }>();

const open = ref(false);
const search = ref('');
const root = ref<HTMLElement | null>(null);
const searchInput = ref<HTMLInputElement | null>(null);

const selectedLabel = computed(() => props.options.find(o => o.value === props.modelValue)?.label || '');

const filtered = computed(() =>
  props.options.filter(o => o.label.toLowerCase().includes(search.value.toLowerCase()))
);

function toggle() {
  open.value = !open.value;
  if (open.value) {
    nextTick(() => searchInput.value?.focus());
  }
}

function choose(opt: Option) {
  emit('update:modelValue', opt.value);
  open.value = false;
  search.value = '';
}

function onClickOutside(e: MouseEvent) {
  if (root.value && !root.value.contains(e.target as Node)) {
    open.value = false;
    search.value = '';
  }
}

onMounted(() => document.addEventListener('mousedown', onClickOutside));
onUnmounted(() => document.removeEventListener('mousedown', onClickOutside));
</script>
