<template>
    <div class="text-start my-4">
        <router-link to="/dash/coupons" class="btn btn-secondary me-2 btn-b">
            <i class="las la-arrow-alt-circle-left"></i>
            Back
        </router-link>
    </div>

    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title text-capitalize">
                    Create Coupon
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="hidden-columns_wrapper" class="dataTables_wrapper dt-bootstrap5">
                        <form class="container" @submit.prevent="handleSubmit">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Code</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            :class="{ 'is-invalid': errors['code'] }"
                                            v-model="formData.code"
                                            placeholder="e.g. SUMMER25"
                                        >
                                        <span class="text-danger d-block mt-2" v-if="errors['code']">
                                            {{ Array.isArray(errors['code']) ? errors['code'][0] : errors['code'] }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Name (optional)</label>
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
                                        <label class="form-label">Type</label>
                                        <select class="form-control" v-model="formData.type" :class="{ 'is-invalid': errors['type'] }">
                                            <option value="percentage">Percentage (%)</option>
                                            <option value="fixed">Fixed Amount</option>
                                        </select>
                                        <span class="text-danger d-block mt-2" v-if="errors['type']">
                                            {{ Array.isArray(errors['type']) ? errors['type'][0] : errors['type'] }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">
                                            Value {{ formData.type === 'percentage' ? '(%)' : '' }}
                                        </label>
                                        <input
                                            type="number"
                                            step="0.01"
                                            min="0"
                                            class="form-control"
                                            :class="{ 'is-invalid': errors['value'] }"
                                            v-model="formData.value"
                                        >
                                        <span class="text-danger d-block mt-2" v-if="errors['value']">
                                            {{ Array.isArray(errors['value']) ? errors['value'][0] : errors['value'] }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Start Date (optional)</label>
                                        <input
                                            type="date"
                                            class="form-control"
                                            :class="{ 'is-invalid': errors['starts_at'] }"
                                            v-model="formData.starts_at"
                                        >
                                        <span class="text-danger d-block mt-2" v-if="errors['starts_at']">
                                            {{ Array.isArray(errors['starts_at']) ? errors['starts_at'][0] : errors['starts_at'] }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Expiry Date (optional)</label>
                                        <input
                                            type="date"
                                            class="form-control"
                                            :class="{ 'is-invalid': errors['expires_at'] }"
                                            v-model="formData.expires_at"
                                        >
                                        <span class="text-danger d-block mt-2" v-if="errors['expires_at']">
                                            {{ Array.isArray(errors['expires_at']) ? errors['expires_at'][0] : errors['expires_at'] }}
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
                                    </div>
                                </div>

                                <div class="col-md-12 text-center my-4">
                                    <button type="submit" class="btn btn-success" :disabled="loading">
                                        {{ loading ? 'Creating...' : 'Create' }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, reactive } from 'vue';
import { useRouter } from 'vue-router';
import { useHead } from '@vueuse/head';
import { useCoupons } from '../../../../composables/useCoupons';

useHead({ title: 'Create Coupon' });

const router = useRouter();
const { create } = useCoupons();

const loading = ref(false);
const errors = reactive<Record<string, any>>({});

const formData = reactive({
    code: '',
    name: '',
    type: 'percentage',
    value: 0,
    starts_at: '',
    expires_at: '',
    status: true,
});

const resetErrors = () => {
    Object.keys(errors).forEach((key) => delete errors[key]);
};

const handleSubmit = async () => {
    resetErrors();
    loading.value = true;

    try {
        await create({ ...formData, status: formData.status ? 1 : 0 });
        window.showSuccessToast?.('Coupon created successfully');
        await router.push('/dash/coupons');
    } catch (error: any) {
        const apiErrors = error?.response?.data?.errors || {};
        Object.assign(errors, apiErrors);
        window.showErrorToast?.(error?.response?.data?.message || 'Failed to create coupon');
    } finally {
        loading.value = false;
    }
};
</script>
