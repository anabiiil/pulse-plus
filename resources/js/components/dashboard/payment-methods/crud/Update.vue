<template>
    <div class="text-start my-4">
        <router-link to="/dash/payment-methods" class="btn btn-secondary btn-b">
            <i class="las la-arrow-alt-circle-left"></i> Back
        </router-link>
    </div>

    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title">
                    Edit Payment Method
                    <span v-if="isSystem" class="badge bg-secondary ms-2">System (name locked)</span>
                </div>
            </div>
            <div class="card-body">
                <form class="container" @submit.prevent="handleSubmit" v-if="!loading">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Name En</label>
                                <input type="text" class="form-control" :class="{ 'is-invalid': errors['name.en'] }" v-model="formData.name.en" :readonly="isSystem" :disabled="isSystem">
                                <span class="text-danger d-block mt-2" v-if="errors['name.en']">{{ errText('name.en') }}</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Name Ar</label>
                                <input type="text" class="form-control" :class="{ 'is-invalid': errors['name.ar'] }" v-model="formData.name.ar" :readonly="isSystem" :disabled="isSystem">
                                <span class="text-danger d-block mt-2" v-if="errors['name.ar']">{{ errText('name.ar') }}</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Description En</label>
                                <textarea class="form-control" rows="3" v-model="formData.description.en"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Description Ar</label>
                                <textarea class="form-control" rows="3" v-model="formData.description.ar"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Image</label>
                                <input type="file" class="form-control" accept="image/*" @change="onImage">
                                <img v-if="preview" :src="preview" alt="preview" style="height:80px;margin-top:10px">
                                <img v-else-if="currentImage" :src="currentImage" alt="current" style="height:80px;margin-top:10px">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Active</label>
                                <v-switch v-model="formData.is_active" density="compact" :color="formData.is_active ? 'success' : ''"></v-switch>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Requires transfer receipt</label>
                                <v-switch v-model="formData.requires_receipt" density="compact" :color="formData.requires_receipt ? 'success' : ''"></v-switch>
                            </div>
                        </div>
                        <div class="col-md-12 text-center my-4">
                            <button type="submit" class="btn btn-success" :disabled="saving">
                                {{ saving ? 'Saving...' : 'Update' }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, reactive, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useHead } from '@vueuse/head';
import axios from 'axios';

useHead({ title: 'Edit Payment Method' });

const router = useRouter();
const route = useRoute();

const loading = ref(true);
const saving = ref(false);
const isSystem = ref(false);
const currentImage = ref<string | null>(null);
const preview = ref<string | null>(null);
const errors = reactive<Record<string, any>>({});
let imageFile: File | null = null;

const formData = reactive({
    name: { en: '', ar: '' },
    description: { en: '', ar: '' },
    is_active: true,
    requires_receipt: false,
});

function errText(key: string) {
    const e = errors[key];
    return Array.isArray(e) ? e[0] : e;
}

function onImage(event: any) {
    const file = event.target.files[0];
    if (file) {
        imageFile = file;
        const reader = new FileReader();
        reader.onload = (e) => { preview.value = e.target?.result as string; };
        reader.readAsDataURL(file);
    }
}

async function load() {
    loading.value = true;
    try {
        const response = await axios.get(`/payment-methods/${route.params.id}`);
        const m = response.data.data;
        isSystem.value = m.is_system;
        formData.name.en = m.name_en || '';
        formData.name.ar = m.name_ar || '';
        formData.description.en = m.description_en || '';
        formData.description.ar = m.description_ar || '';
        formData.is_active = m.is_active;
        formData.requires_receipt = m.requires_receipt;
        currentImage.value = m.image_url || null;
    } catch (error) {
        await router.push('/dash/payment-methods');
    } finally {
        loading.value = false;
    }
}

async function handleSubmit() {
    Object.keys(errors).forEach((k) => delete errors[k]);
    saving.value = true;
    try {
        const data = new FormData();
        data.append('_method', 'PATCH');
        if (!isSystem.value) {
            data.append('name[en]', formData.name.en);
            data.append('name[ar]', formData.name.ar);
        }
        data.append('description[en]', formData.description.en || '');
        data.append('description[ar]', formData.description.ar || '');
        data.append('is_active', formData.is_active ? '1' : '0');
        data.append('requires_receipt', formData.requires_receipt ? '1' : '0');
        if (imageFile) data.append('image', imageFile);

        await axios.post(`/payment-methods/${route.params.id}`, data);
        (window as any).showSuccessToast?.('Payment method updated');
        await router.push('/dash/payment-methods');
    } catch (error: any) {
        if (error?.response?.status === 422) {
            Object.assign(errors, error.response.data.errors || {});
        }
        (window as any).showErrorToast?.(error?.response?.data?.message || 'Failed to save');
    } finally {
        saving.value = false;
    }
}

onMounted(load);
</script>
