<template>
    <div class="text-start my-4">
        <router-link to="/dash/items" class="btn btn-secondary me-2 btn-b">
            <i class="las la-arrow-alt-circle-left"></i>
            Back
        </router-link>
    </div>

    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title text-capitalize">Create Item</div>
            </div>
            <div class="card-body">
                <form class="container" @submit.prevent="handleSubmit">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Type <span class="text-danger">*</span></label>
                                <select
                                    class="form-select"
                                    :class="{ 'is-invalid': errors['type'] }"
                                    v-model="formData.type"
                                >
                                    <option value="">— Select Type —</option>
                                    <option v-for="t in itemTypes" :key="t" :value="t">{{ t }}</option>
                                </select>
                                <small class="text-muted">
                                    Code will be auto-generated (e.g. {{ formData.type || 'C' }}-1, {{ formData.type || 'C' }}-2 …)
                                </small>
                                <span class="text-danger d-block mt-2" v-if="errors['type']">
                                    {{ Array.isArray(errors['type']) ? errors['type'][0] : errors['type'] }}
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
                                {{ loading ? 'Creating...' : 'Create Item' }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useHead } from '@vueuse/head';
import { useRouter } from 'vue-router';
import { useItems } from '../../../../composables/useItems';

useHead({ title: 'Create Item' });

const router = useRouter();
const { loading, create } = useItems();

const itemTypes = ['C', 'N', 'B', 'D'];

const formData = ref({
    type: '',
    status: true,
});

const errors = ref<Record<string, string | string[]>>({});

const handleSubmit = async (): Promise<void> => {
    errors.value = {};

    try {
        await create({
            type: formData.value.type,
            status: formData.value.status ? 1 : 0,
        });

        await router.push('/dash/items');
    } catch (err: any) {
        if (err.response?.status === 422) {
            errors.value = err.response.data.errors || {};
        }
    }
};
</script>
