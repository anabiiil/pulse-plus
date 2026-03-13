<template>
    <div class="relative" ref="containerRef">
        <!-- Selected chips + search input -->
        <div
            class="bg-gray-50 border-0 shadow-xl font-semibold rounded-[30px] w-full p-4 pr-12 min-h-[56px] flex flex-wrap gap-2 items-center cursor-text transition-shadow duration-300 ease-in-out hover:shadow-2xl"
            @click="focusInput"
        >
            <!-- Selected chips -->
            <span
                v-for="item in modelValue"
                :key="item.id"
                class="inline-flex items-center gap-1 bg-teal-500 text-white text-sm font-semibold px-3 py-1 rounded-full"
            >
                {{ item.name }}
                <button
                    type="button"
                    @click.stop="remove(item)"
                    class="hover:text-teal-200 transition-colors leading-none"
                >
                    <i class="pi pi-times text-[10px]"></i>
                </button>
            </span>

            <!-- Search input -->
            <input
                ref="inputRef"
                v-model="search"
                type="text"
                :placeholder="modelValue.length === 0 ? placeholder : ''"
                class="flex-1 min-w-[120px] bg-transparent border-none outline-none font-semibold text-[#123057] placeholder-gray-400"
                @focus="open = true"
                @keydown.backspace="onBackspace"
                @keydown.escape="open = false"
            />

            <!-- Icon -->
            <i class="pi pi-heart absolute top-1/2 right-5 text-gray-400 -translate-y-1/2 text-[18px] pointer-events-none"></i>
        </div>

        <!-- Dropdown -->
        <transition
            enter-active-class="transition duration-150 ease-out"
            enter-from-class="opacity-0 translate-y-1"
            enter-to-class="opacity-100 translate-y-0"
            leave-active-class="transition duration-100 ease-in"
            leave-from-class="opacity-100 translate-y-0"
            leave-to-class="opacity-0 translate-y-1"
        >
            <div
                v-if="open && filteredOptions.length > 0"
                class="absolute z-50 mt-2 w-full bg-white rounded-[20px] shadow-2xl overflow-hidden border border-gray-100"
            >
                <ul class="max-h-52 overflow-y-auto py-2">
                    <li
                        v-for="option in filteredOptions"
                        :key="option.id"
                        @mousedown.prevent="select(option)"
                        class="flex items-center gap-3 px-5 py-3 cursor-pointer hover:bg-teal-50 transition-colors"
                        :class="{ 'bg-teal-50': isSelected(option) }"
                    >
                        <span
                            class="w-4 h-4 rounded-full border-2 flex-shrink-0 flex items-center justify-center transition-colors"
                            :class="isSelected(option) ? 'bg-teal-500 border-teal-500' : 'border-gray-300'"
                        >
                            <i v-if="isSelected(option)" class="pi pi-check text-white text-[8px]"></i>
                        </span>
                        <span class="text-[#123057] font-semibold text-sm">{{ option.name }}</span>
                    </li>
                </ul>

                <!-- No results -->
                <div v-if="filteredOptions.length === 0 && search" class="px-5 py-4 text-gray-400 text-sm text-center">
                    {{ noResultsText }}
                </div>
            </div>
        </transition>
    </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted } from 'vue';

export interface SelectOption {
    id: number | string;
    name: string;
}

const props = withDefaults(defineProps<{
    modelValue: SelectOption[];
    options: SelectOption[];
    placeholder?: string;
    noResultsText?: string;
}>(), {
    placeholder: 'Search...',
    noResultsText: 'No results found',
});

const emit = defineEmits<{
    'update:modelValue': [value: SelectOption[]];
}>();

const open        = ref(false);
const search      = ref('');
const inputRef    = ref<HTMLInputElement | null>(null);
const containerRef = ref<HTMLElement | null>(null);

const filteredOptions = computed(() =>
    props.options.filter(option =>
        option.name.toLowerCase().includes(search.value.toLowerCase()) &&
        !props.modelValue.some(s => s.id === option.id)
    )
);

const isSelected = (option: SelectOption): boolean =>
    props.modelValue.some(s => s.id === option.id);

const focusInput = (): void => {
    inputRef.value?.focus();
    open.value = true;
};

const select = (option: SelectOption): void => {
    emit('update:modelValue', [...props.modelValue, option]);
    search.value = '';
};

const remove = (option: SelectOption): void => {
    emit('update:modelValue', props.modelValue.filter(s => s.id !== option.id));
};

const onBackspace = (): void => {
    if (search.value === '' && props.modelValue.length > 0) {
        remove(props.modelValue[props.modelValue.length - 1]);
    }
};

const onClickOutside = (event: MouseEvent): void => {
    if (containerRef.value && !containerRef.value.contains(event.target as Node)) {
        open.value = false;
        search.value = '';
    }
};

onMounted(() => document.addEventListener('mousedown', onClickOutside));
onUnmounted(() => document.removeEventListener('mousedown', onClickOutside));
</script>

