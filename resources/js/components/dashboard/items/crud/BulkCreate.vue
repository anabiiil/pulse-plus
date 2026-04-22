<template>
    <!-- Trigger Button -->
    <button class="btn btn-warning btn-b me-2" @click="openModal">
        <i class="fe fe-layers me-1"></i> Bulk Create
    </button>

    <!-- Modal -->
    <teleport to="body">
        <div v-if="showModal" class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-4 border-0 shadow-lg">

                    <!-- Step 1: Form -->
                    <template v-if="step === 'form'">
                        <div class="modal-header border-0 pb-0">
                            <h5 class="modal-title fw-bold">Bulk Create Items</h5>
                            <button type="button" class="btn-close" @click="closeModal"></button>
                        </div>
                        <div class="modal-body px-4 pb-4">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Type <span class="text-danger">*</span></label>
                                <div class="d-flex gap-2">
                                    <button
                                        v-for="t in itemTypes"
                                        :key="t"
                                        type="button"
                                        class="btn flex-fill fw-bold fs-5"
                                        :class="form.type === t ? 'btn-dark' : 'btn-outline-secondary'"
                                        @click="form.type = t"
                                    >{{ t }}</button>
                                </div>
                                <span class="text-danger small mt-1 d-block" v-if="errors.type">{{ errors.type }}</span>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Number of Items <span class="text-danger">*</span></label>
                                <input
                                    type="number"
                                    class="form-control"
                                    :class="{ 'is-invalid': errors.count }"
                                    v-model.number="form.count"
                                    min="1"
                                    max="500"
                                    placeholder="e.g. 10"
                                >
                                <div class="invalid-feedback" v-if="errors.count">{{ errors.count }}</div>
                                <small class="text-muted">
                                    Will create codes: {{ form.type || '?' }}-X through {{ form.type || '?' }}-X+{{ form.count || 0 }}
                                </small>
                            </div>
                        </div>
                        <div class="modal-footer border-0 pt-0">
                            <button class="btn btn-secondary" @click="closeModal">Cancel</button>
                            <button class="btn btn-warning fw-bold" :disabled="loading" @click="handleCreate">
                                <span v-if="loading"><i class="fe fe-loader me-1"></i> Creating...</span>
                                <span v-else><i class="fe fe-layers me-1"></i> Create {{ form.count || '' }} Items</span>
                            </button>
                        </div>
                    </template>

                    <!-- Step 2: Results -->
                    <template v-else>
                        <div class="modal-header border-0 pb-0">
                            <h5 class="modal-title fw-bold text-success">
                                <i class="fe fe-check-circle me-2"></i>
                                {{ createdItems.length }} Items Created!
                            </h5>
                            <button type="button" class="btn-close" @click="closeModal"></button>
                        </div>
                        <div class="modal-body px-4 pb-2" style="max-height: 360px; overflow-y: auto;">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered align-middle mb-0">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>Code</th>
                                            <th>Type</th>
                                            <th>QR</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, idx) in createdItems" :key="item.id">
                                            <td class="text-muted">{{ idx + 1 }}</td>
                                            <td><code class="fw-bold text-primary">{{ item.code }}</code></td>
                                            <td><span class="badge bg-secondary">{{ item.type }}</span></td>
                                            <td>
                                                <a
                                                    v-if="item.qr_code_path"
                                                    :href="item.qr_code_path"
                                                    :download="`item-qr-${item.code}.svg`"
                                                    class="btn btn-xs btn-outline-success btn-sm py-0 px-2"
                                                    title="Download QR"
                                                >
                                                    <i class="fe fe-download"></i>
                                                </a>
                                                <span v-else class="text-muted">—</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <button class="btn btn-secondary" @click="closeModal">Close</button>
                            <button class="btn btn-success fw-bold" @click="downloadAll">
                                <i class="fe fe-download me-1"></i> Download All QR Codes
                            </button>
                        </div>
                    </template>

                </div>
            </div>
        </div>
    </teleport>
</template>

<script setup lang="ts">
import { ref, reactive } from 'vue';
import { useItems } from '../../../../composables/useItems';

const emit = defineEmits<{ (e: 'created'): void }>();

const { loading, bulkCreate } = useItems();

const itemTypes = ['C', 'N', 'B', 'D'];

const showModal = ref(false);
const step = ref<'form' | 'results'>('form');
const createdItems = ref<any[]>([]);
const errors = reactive<{ type?: string; count?: string }>({});

const form = reactive({
    type: '',
    count: 10,
});

const openModal = () => {
    form.type = '';
    form.count = 10;
    errors.type = undefined;
    errors.count = undefined;
    createdItems.value = [];
    step.value = 'form';
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    if (step.value === 'results') {
        emit('created');
    }
};

const handleCreate = async () => {
    errors.type = undefined;
    errors.count = undefined;

    if (!form.type) {
        errors.type = 'Please select a type.';
        return;
    }
    if (!form.count || form.count < 1) {
        errors.count = 'Please enter a valid number (min 1).';
        return;
    }

    try {
        const items = await bulkCreate({ type: form.type, count: form.count });
        createdItems.value = items;
        step.value = 'results';
    } catch (err: any) {
        if (err.response?.status === 422) {
            const e = err.response.data.errors || {};
            errors.type = e.type?.[0];
            errors.count = e.count?.[0];
        }
    }
};

const downloadAll = async () => {
    for (const item of createdItems.value) {
        if (!item.qr_code_path) continue;

        try {
            const res = await fetch(item.qr_code_path);
            const blob = await res.blob();
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `item-qr-${item.code}.svg`;
            a.click();
            URL.revokeObjectURL(url);
            // Small delay to avoid browser blocking multiple downloads
            await new Promise(r => setTimeout(r, 150));
        } catch {
            // Skip failed downloads silently
        }
    }
};
</script>

