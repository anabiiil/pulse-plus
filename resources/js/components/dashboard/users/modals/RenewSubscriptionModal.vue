<template>
    <v-dialog v-model="isOpen" max-width="440" persistent>
        <v-card>
            <v-card-title class="pa-4 pb-2">
                <span class="text-h6">Renew Subscription</span>
            </v-card-title>

            <v-divider />

            <v-card-text class="pa-4">
                <div v-if="user?.subscription" class="mb-3">
                    <p class="mb-1">
                        Renew <strong>{{ user.subscription.subscription_name }}</strong> for <strong>{{ user?.name }}</strong>?
                    </p>
                    <p class="text-muted mb-0" style="font-size: 0.875rem;">
                        A new subscription period will start from <strong>today</strong>. The current period will be marked as ended.
                    </p>
                </div>
                <div v-else class="text-warning">
                    <i class="fe fe-alert-circle me-1"></i> This user has no subscription to renew.
                </div>
            </v-card-text>

            <v-divider />

            <v-card-actions class="pa-4 gap-2 justify-end">
                <button class="btn btn-secondary" @click="close" :disabled="saving">Cancel</button>
                <button
                    class="btn btn-success"
                    @click="submit"
                    :disabled="saving || !user?.subscription"
                >
                    <span v-if="saving" class="spinner-border spinner-border-sm me-1"></span>
                    <i v-else class="fe fe-refresh-cw me-1"></i>
                    Renew
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
        name: string;
        subscription?: {
            subscription_name: string | null;
        } | null;
    } | null;
}>();

const emit = defineEmits<{
    (e: 'update:modelValue', value: boolean): void;
    (e: 'renewed', user: any): void;
}>();

const isOpen = ref(props.modelValue);
const saving = ref(false);

watch(() => props.modelValue, (val) => {
    isOpen.value = val;
});

watch(isOpen, (val) => {
    emit('update:modelValue', val);
});

const close = (): void => {
    isOpen.value = false;
};

const submit = async (): Promise<void> => {
    if (!props.user) { return; }

    saving.value = true;

    try {
        const response = await axios.post(`/users/${props.user.id}/subscription/renew`);
        emit('renewed', response.data.data);
        close();

        if (window.showSuccessToast) {
            window.showSuccessToast('Subscription renewed successfully.');
        }
    } catch (err: any) {
        if (window.showErrorToast) {
            window.showErrorToast(err.response?.data?.message || 'Failed to renew subscription.');
        }
    } finally {
        saving.value = false;
    }
};
</script>

