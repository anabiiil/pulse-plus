<template>
    <v-dialog v-model="isOpen" max-width="480" persistent>
        <v-card>
            <v-card-title class="pa-4 pb-2">
                <span class="text-h6">Update Subscription Dates</span>
            </v-card-title>
            <v-card-subtitle class="px-4 pb-2 text-muted">
                {{ user?.subscription?.subscription_name }}
            </v-card-subtitle>

            <v-divider />

            <v-card-text class="pa-4">
                <div class="mb-3">
                    <label class="form-label">Start Date <span class="text-danger">*</span></label>
                    <input
                        type="date"
                        v-model="form.start_date"
                        class="form-control"
                        :class="{ 'is-invalid': errors.start_date }"
                    >
                    <div v-if="errors.start_date" class="invalid-feedback">{{ errors.start_date }}</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">End Date <span class="text-danger">*</span></label>
                    <input
                        type="date"
                        v-model="form.end_date"
                        class="form-control"
                        :class="{ 'is-invalid': errors.end_date }"
                    >
                    <div v-if="errors.end_date" class="invalid-feedback">{{ errors.end_date }}</div>
                </div>
            </v-card-text>

            <v-divider />

            <v-card-actions class="pa-4 gap-2 justify-end">
                <button class="btn btn-secondary" @click="close" :disabled="saving">Cancel</button>
                <button class="btn btn-primary" @click="submit" :disabled="saving">
                    <span v-if="saving" class="spinner-border spinner-border-sm me-1"></span>
                    Save Dates
                </button>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue';
import axios from 'axios';

const props = defineProps<{
    modelValue: boolean;
    user: {
        id: number;
        subscription?: {
            subscription_name: string | null;
            start_date: string;
            end_date: string;
        } | null;
    } | null;
}>();

const emit = defineEmits<{
    (e: 'update:modelValue', value: boolean): void;
    (e: 'updated', user: any): void;
}>();

const isOpen = ref(props.modelValue);
const saving = ref(false);
const errors = ref<Record<string, string>>({});

const form = ref({
    start_date: '',
    end_date: '',
});

watch(() => props.modelValue, (val) => {
    isOpen.value = val;
    if (val && props.user?.subscription) {
        form.value.start_date = props.user.subscription.start_date;
        form.value.end_date = props.user.subscription.end_date;
        errors.value = {};
    }
});

watch(isOpen, (val) => {
    emit('update:modelValue', val);
});

const close = (): void => {
    isOpen.value = false;
};

const submit = async (): Promise<void> => {
    if (!props.user) { return; }

    errors.value = {};
    saving.value = true;

    try {
        const response = await axios.patch(`/users/${props.user.id}/subscription/dates`, form.value);
        emit('updated', response.data.data);
        close();

        if (window.showSuccessToast) {
            window.showSuccessToast('Subscription dates updated successfully.');
        }
    } catch (err: any) {
        if (err.response?.status === 422) {
            const serverErrors = err.response.data?.errors || {};
            errors.value = Object.fromEntries(
                Object.entries(serverErrors).map(([key, msgs]) => [key, (msgs as string[])[0]])
            );
        } else if (window.showErrorToast) {
            window.showErrorToast(err.response?.data?.message || 'Failed to update subscription dates.');
        }
    } finally {
        saving.value = false;
    }
};
</script>

