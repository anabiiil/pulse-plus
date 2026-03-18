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
                                <label class="form-label">Name <span class="text-muted">(optional)</span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    :class="{ 'is-invalid': errors['name'] }"
                                    v-model="formData.name"
                                    placeholder="Enter item name"
                                >
                                <span class="text-danger d-block mt-2" v-if="errors['name']">
                                    {{ Array.isArray(errors['name']) ? errors['name'][0] : errors['name'] }}
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

                        <!-- QR Code Preview -->
                        <div class="col-lg-6 d-flex flex-column align-items-center py-2">
                            <label class="form-label w-100">QR Code</label>
                            <canvas ref="qrCanvas" class="border rounded p-2 shadow-sm mb-2" style="max-width: 300px  !important;height:300px;"></canvas>
                            <button type="button" class="btn btn-sm btn-success" @click="downloadQr">
                                <i class="fe fe-download me-1"></i> Download QR
                            </button>
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
import { ref, onMounted, nextTick, watch } from 'vue';
import { useHead } from '@vueuse/head';
import { useRouter } from 'vue-router';
import { useItems } from '../../../../composables/useItems';
import QRCode from 'qrcode';
// @ts-ignore
import { useToast } from 'vue-toastification';

const props = defineProps<{ id: string }>();

useHead({ title: 'Edit Item' });

const router = useRouter();
const toast = useToast();
const { loading, getItem, update, item } = useItems();

const formData = ref({ name: '', status: true });
const errors = ref<Record<string, string | string[]>>({});
const qrCanvas = ref<HTMLCanvasElement | null>(null);

const generateQr = async () => {
    await nextTick();
    if (qrCanvas.value && item.value?.uuid) {
        await QRCode.toCanvas(qrCanvas.value, item.value.uuid, {
            width: 180,
            margin: 2,
            color: { dark: '#000000', light: '#ffffff' },
        });
    }
};

const downloadQr = () => {
    if (!qrCanvas.value || !item.value) {
        return;
    }
    const link = document.createElement('a');
    link.download = `item-qr-${item.value.uuid}.png`;
    link.href = qrCanvas.value.toDataURL('image/png');
    link.click();
};

watch(item, async (newItem) => {
    if (newItem) {
        formData.value.name = newItem.name ?? '';
        formData.value.status = newItem.status;
        await generateQr();
    }
});

const handleSubmit = async () => {
    errors.value = {};

    try {
        await update(Number(props.id), {
            name: formData.value.name || null,
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


