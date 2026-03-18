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

    <!-- QR Code Modal (shown after creation) -->
    <div v-if="createdItem" class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Item Created Successfully</h5>
                </div>
                <div class="modal-body text-center">
                    <p class="text-muted mb-1">Item UUID:</p>
                    <code class="d-block mb-4 fs-13">{{ createdItem.uuid }}</code>

                    <div class="d-flex justify-content-center mb-4">
                        <canvas ref="qrCanvas" style="max-width: 100%; height: auto;"></canvas>
                    </div>

                    <div class="d-flex justify-content-center gap-2">
                        <button class="btn btn-primary" @click="downloadQr">
                            <i class="fe fe-download me-1"></i> Download QR
                        </button>
                        <button class="btn btn-secondary" @click="goToList">
                            <i class="fe fe-list me-1"></i> Go to List
                        </button>
                        <router-link :to="`/dash/items/${createdItem.id}/show`" class="btn btn-info">
                            <i class="fe fe-eye me-1"></i> View Detail
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, nextTick } from 'vue';
import { useHead } from '@vueuse/head';
import { useRouter } from 'vue-router';
import { useItems } from '../../../../composables/useItems';
import QRCode from 'qrcode';

useHead({ title: 'Create Item' });

const router = useRouter();
const { loading, create } = useItems();

const formData = ref({
    name: '',
    status: true,
});

const errors = ref<Record<string, string | string[]>>({});
const createdItem = ref<any>(null);
const qrCanvas = ref<HTMLCanvasElement | null>(null);

const generateQr = async () => {
    await nextTick();
    if (qrCanvas.value && createdItem.value?.uuid) {
        await QRCode.toCanvas(qrCanvas.value, createdItem.value.uuid, {
            width: 220,
            margin: 2,
            color: { dark: '#000000', light: '#ffffff' },
        });
    }
};

const downloadQr = () => {
    if (!qrCanvas.value || !createdItem.value) {
        return;
    }
    const link = document.createElement('a');
    link.download = `item-qr-${createdItem.value.uuid}.png`;
    link.href = qrCanvas.value.toDataURL('image/png');
    link.click();
};

const goToList = () => {
    router.push('/dash/items');
};

const handleSubmit = async () => {
    errors.value = {};

    try {
        const response = await create({
            name: formData.value.name || null,
            status: formData.value.status ? 1 : 0,
        });

        createdItem.value = response.data;
        await generateQr();
    } catch (err: any) {
        if (err.response?.status === 422) {
            errors.value = err.response.data.errors || {};
        }
    }
};
</script>


