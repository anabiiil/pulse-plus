<template>
    <div class="text-start my-4">
        <router-link to="/dash/items" class="btn btn-secondary me-2 btn-b">
            <i class="las la-arrow-alt-circle-left"></i>
            Back
        </router-link>
    </div>

    <div class="col-xl-12">
        <div v-if="loading" class="text-center py-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <div v-else-if="item" class="card custom-card">
            <div class="card-header">
                <div class="card-title text-capitalize">Item QR Code</div>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Item Details -->
                    <div class="col-lg-6">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>ID</th>
                                    <td>{{ item.id }}</td>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <td>
                                        <span v-if="item.name">{{ item.name }}</span>
                                        <span v-else class="text-muted fst-italic">—</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>UUID</th>
                                    <td><code class="fs-12">{{ item.uuid }}</code></td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge" :class="item.status ? 'bg-success' : 'bg-danger'">
                                            {{ item.status ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $formatDate(item.created_at) }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="mt-3 d-flex gap-2">
                            <router-link :to="`/dash/items/${item.id}/edit`" class="btn btn-primary">
                                <i class="fe fe-edit me-1"></i> Edit
                            </router-link>
                        </div>
                    </div>

                    <!-- QR Code -->
                    <div class="col-lg-6 d-flex flex-column align-items-center justify-content-center py-4">
                        <p class="text-muted mb-3">Scan this QR code to get the item UUID</p>
                        <canvas ref="qrCanvas" class="mb-4 border rounded p-2 shadow-sm" style="max-width: 300px  !important;height:300px;"></canvas>
                        <button class="btn btn-success" @click="downloadQr">
                            <i class="fe fe-download me-1"></i> Download QR Code
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted, nextTick } from 'vue';
import { useHead } from '@vueuse/head';
import { useItems } from '../../../../composables/useItems';
import QRCode from 'qrcode';

const props = defineProps<{ id: string }>();

useHead({ title: 'Item QR Code' });

const { loading, getItem, item } = useItems();
const qrCanvas = ref<HTMLCanvasElement | null>(null);

const generateQr = async () => {
    await nextTick();
    if (qrCanvas.value && item.value?.uuid) {
        await QRCode.toCanvas(qrCanvas.value, item.value.uuid, {
            width: 220,
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
    link.download = `${item.value.qr_code_path}`;
    link.href = qrCanvas.value.toDataURL('image/png');
    link.click();
};

onMounted(async () => {
    await getItem(Number(props.id));
    await generateQr();
});
</script>


