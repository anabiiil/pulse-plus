<template>
    <div class="text-start my-4">
        <router-link to="/dash/items" class="btn btn-secondary me-2 btn-b">
            <i class="las la-arrow-alt-circle-left"></i>
            Back
        </router-link>
    </div>

    <div class="col-xl-12">
        <div v-if="loading && !item" class="text-center py-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <div v-else class="card custom-card">
            <div class="card-header">
                <div class="card-title text-capitalize">Edit Item</div>
            </div>
            <div class="card-body">
                <form class="container" @submit.prevent="handleSubmit">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label class="form-label">UUID</label>
                                <input
                                    type="text"
                                    class="form-control bg-light"
                                    :value="item?.uuid"
                                    readonly
                                >
                                <small class="text-muted">UUID is auto-generated and cannot be changed.</small>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Code</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <span v-if="item?.type" class="badge bg-secondary">{{ item.type }}</span>
                                    </span>
                                    <input
                                        type="text"
                                        class="form-control bg-light fw-bold text-primary"
                                        :value="item?.code ?? '—'"
                                        readonly
                                    >
                                </div>
                                <small class="text-muted">Code is auto-generated and cannot be changed.</small>
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

                        <!-- QR Code Preview (from backend) -->
                        <div class="col-lg-6 d-flex flex-column align-items-center py-2">
                            <label class="form-label w-100">QR Code</label>
                            <template v-if="item?.qr_code_path">
                                <img
                                    :src="item.qr_code_path"
                                    alt="QR Code"
                                    class="border rounded p-2 shadow-sm mb-2"
                                    style="width: 200px; height: 200px; object-fit: contain;"
                                >
                                <a
                                    :href="item.qr_code_path"
                                    :download="`item-qr-${item.code ?? item.uuid}.svg`"
                                    class="btn btn-sm btn-success"
                                >
                                    <i class="fe fe-download me-1"></i> Download QR
                                </a>
                            </template>
                            <span v-else class="text-muted fst-italic">No QR code available</span>
                        </div>

                        <div class="col-md-12 text-center my-4">
                            <button type="submit" class="btn btn-primary" :disabled="loading">
                                {{ loading ? 'Saving...' : 'Save Changes' }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted, watch } from 'vue';
import { useHead } from '@vueuse/head';
import { useRouter } from 'vue-router';
import { useItems } from '../../../../composables/useItems';
// @ts-ignore
import { useToast } from 'vue-toastification';

const props = defineProps<{ id: string }>();

useHead({ title: 'Edit Item' });

const router = useRouter();
const toast = useToast();
const { loading, getItem, update, item } = useItems();

const formData = ref({ status: true });
const errors = ref<Record<string, string | string[]>>({});

watch(item, (newItem) => {
    if (newItem) {
        formData.value.status = newItem.status === 'active';
    }
});

const handleSubmit = async () => {
    errors.value = {};

    try {
        await update(Number(props.id), {
            status: formData.value.status ? 1 : 0,
        });

        toast.success('Item updated successfully');
        router.push('/dash/items');
    } catch (err: any) {
        if (err.response?.status === 422) {
            errors.value = err.response.data.errors || {};
        } else {
            toast.error('Failed to update item');
        }
    }
};

onMounted(async () => {
    await getItem(Number(props.id));
});
</script>


