<template>
    <div class="text-start my-4">
        <router-link to="/dash/payment-methods" class="btn btn-secondary btn-b">
            <i class="las la-arrow-alt-circle-left"></i> Back
        </router-link>
    </div>

    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header"><div class="card-title">Add Payment Method</div></div>
            <div class="card-body">
                <form class="container" @submit.prevent="handleSubmit">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Name En</label>
                                <input type="text" class="form-control" :class="{ 'is-invalid': errors['name.en'] }" v-model="formData.name.en">
                                <span class="text-danger d-block mt-2" v-if="errors['name.en']">{{ errText('name.en') }}</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Name Ar</label>
                                <input type="text" class="form-control" :class="{ 'is-invalid': errors['name.ar'] }" v-model="formData.name.ar">
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
                                <v-switch v-model="formData.requires_receipt" density="compact" :color="formData.requires_receipt ? 'success' : ''" hint="Customer must upload a receipt at checkout"></v-switch>
                            </div>
                        </div>
                        <div class="col-md-12 text-center my-4">
                            <button type="submit" class="btn btn-success" :disabled="loading">
                                {{ loading ? 'Saving...' : 'Save' }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, reactive } from 'vue';
import { useRouter } from 'vue-router';
import { useHead } from '@vueuse/head';
import axios from 'axios';

useHead({ title: 'Add Payment Method' });

const router = useRouter();
const loading = ref(false);
const errors = reactive<Record<string, any>>({});
const preview = ref<string | null>(null);
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

async function handleSubmit() {
    Object.keys(errors).forEach((k) => delete errors[k]);
    loading.value = true;
    try {
        const data = new FormData();
        data.append('name[en]', formData.name.en);
        data.append('name[ar]', formData.name.ar);
        data.append('description[en]', formData.description.en || '');
        data.append('description[ar]', formData.description.ar || '');
        data.append('is_active', formData.is_active ? '1' : '0');
        data.append('requires_receipt', formData.requires_receipt ? '1' : '0');
        if (imageFile) data.append('image', imageFile);

        await axios.post('/payment-methods', data);
        (window as any).showSuccessToast?.('Payment method created');
        await router.push('/dash/payment-methods');
    } catch (error: any) {
        if (error?.response?.status === 422) {
            Object.assign(errors, error.response.data.errors || {});
        }
        (window as any).showErrorToast?.(error?.response?.data?.message || 'Failed to save');
    } finally {
        loading.value = false;
    }
}
</script>
