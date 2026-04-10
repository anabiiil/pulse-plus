<template>
    <div class="text-start my-4">
        <router-link to="/dash/subscriptions" class="btn btn-secondary me-2 btn-b">
            <i class="las la-arrow-alt-circle-left"></i>
            Back
        </router-link>
    </div>

    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title text-capitalize">
                    Update Subscription ({{ formData.name }})
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="hidden-columns_wrapper" class="dataTables_wrapper dt-bootstrap5">
                        <form class="container" @submit.prevent="handleSubmit" v-if="!loading">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Name <span class="text-danger">*</span></label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            :class="{ 'is-invalid': errors['name'] }"
                                            v-model="formData.name"
                                        >
                                        <span class="text-danger d-block mt-2" v-if="errors['name']">
                                            {{ Array.isArray(errors['name']) ? errors['name'][0] : errors['name'] }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Months <span class="text-danger">*</span></label>
                                        <input
                                            type="number"
                                            class="form-control"
                                            :class="{ 'is-invalid': errors['months'] }"
                                            v-model.number="formData.months"
                                            min="1"
                                            max="120"
                                        >
                                        <span class="text-danger d-block mt-2" v-if="errors['months']">
                                            {{ Array.isArray(errors['months']) ? errors['months'][0] : errors['months'] }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea
                                            class="form-control"
                                            :class="{ 'is-invalid': errors['description'] }"
                                            v-model="formData.description"
                                            rows="3"
                                        ></textarea>
                                        <span class="text-danger d-block mt-2" v-if="errors['description']">
                                            {{ Array.isArray(errors['description']) ? errors['description'][0] : errors['description'] }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Status</label>
                                        <v-switch
                                            v-model="formData.status"
                                            density="compact"
                                            :color="formData.status ? 'success' : ''"
                                            label=""
                                        ></v-switch>
                                        <span class="text-danger d-block mt-2" v-if="errors['status']">
                                            {{ Array.isArray(errors['status']) ? errors['status'][0] : errors['status'] }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-12 text-center my-4">
                                    <button type="submit" class="btn btn-success" :disabled="loading">
                                        {{ loading ? 'Updating...' : 'Update' }}
                                    </button>
                                </div>
                            </div>
                        </form>

                        <div v-else class="text-center py-4">
                            <v-progress-circular indeterminate color="primary"></v-progress-circular>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, reactive, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useHead } from '@vueuse/head';
import { useSubscriptions } from '../../../../composables/useSubscriptions';

declare global {
    interface Window {
        showErrorToast: (message: string) => void;
        showSuccessToast: (message: string) => void;
    }
}

useHead({ title: 'Update Subscription' });

const router = useRouter();
const route = useRoute();
const { update, getSubscription: fetchSubscription, subscription } = useSubscriptions();

const loading = ref(true);
const errors = reactive<Record<string, any>>({});
const subscriptionId = ref<number>(Number(Array.isArray(route.params.id) ? route.params.id[0] : route.params.id));

const formData = reactive({
    name: '',
    months: 1,
    description: '',
    status: true,
});

const loadSubscription = async () => {
    try {
        loading.value = true;
        await fetchSubscription(subscriptionId.value);

        if (subscription.value) {
            formData.name = subscription.value.name || '';
            formData.months = subscription.value.months || 1;
            formData.description = subscription.value.description || '';
            formData.status = subscription.value.status;
        }
    } catch (error: any) {
        window.showErrorToast(error?.response?.data?.message || 'Failed to load subscription');
        await router.push('/dash/subscriptions');
    } finally {
        loading.value = false;
    }
};

const resetErrors = () => {
    Object.keys(errors).forEach(key => delete errors[key]);
};

const handleSubmit = async () => {
    resetErrors();
    loading.value = true;

    try {
        await update(subscriptionId.value, {
            name: formData.name,
            months: formData.months,
            description: formData.description || undefined,
            status: formData.status ? '1' : '0',
        });

        await router.push('/dash/subscriptions');
    } catch (error: any) {
        const apiErrors = error?.response?.data?.errors || {};
        Object.assign(errors, apiErrors);
        window.showErrorToast(error?.response?.data?.message || 'Failed to update subscription');
    } finally {
        loading.value = false;
    }
};

onMounted(() => {
    loadSubscription();
});
</script>

