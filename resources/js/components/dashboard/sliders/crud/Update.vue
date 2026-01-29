<template>
    <div class="text-start my-4">
        <router-link to="/dash/sliders" class="btn btn-secondary me-2 btn-b">
            <i class="las la-arrow-alt-circle-left"></i>
            Back
        </router-link>
    </div>

    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title text-capitalize">
                    Update Slider ({{ formData?.title?.en }})
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="hidden-columns_wrapper" class="dataTables_wrapper dt-bootstrap5">
                        <form class="container" @submit.prevent="handleSubmit" v-if="!loading">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Title En</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            :class="{ 'is-invalid': errors['title.en'] }"
                                            v-model="formData.title.en"
                                        >
                                        <span class="text-danger d-block mt-2" v-if="errors['title.en']">
                                            {{ Array.isArray(errors['title.en']) ? errors['title.en'][0] : errors['title.en'] }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Title Ar</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            :class="{ 'is-invalid': errors['title.ar'] }"
                                            v-model="formData.title.ar"
                                        >
                                        <span class="text-danger d-block mt-2" v-if="errors['title.ar']">
                                            {{ Array.isArray(errors['title.ar']) ? errors['title.ar'][0] : errors['title.ar'] }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Description En</label>
                                        <textarea
                                            class="form-control"
                                            :class="{ 'is-invalid': errors['desc.en'] }"
                                            v-model="formData.desc.en"
                                            rows="3"
                                        ></textarea>
                                        <span class="text-danger d-block mt-2" v-if="errors['desc.en']">
                                            {{ Array.isArray(errors['desc.en']) ? errors['desc.en'][0] : errors['desc.en'] }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Description Ar</label>
                                        <textarea
                                            class="form-control"
                                            :class="{ 'is-invalid': errors['desc.ar'] }"
                                            v-model="formData.desc.ar"
                                            rows="3"
                                        ></textarea>
                                        <span class="text-danger d-block mt-2" v-if="errors['desc.ar']">
                                            {{ Array.isArray(errors['desc.ar']) ? errors['desc.ar'][0] : errors['desc.ar'] }}
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

                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Image</label>
                                        <input
                                            type="file"
                                            class="form-control"
                                            :class="{ 'is-invalid': errors['image'] }"
                                            @change="handleImageChange"
                                            accept="image/*"
                                        >
                                        <span class="text-danger d-block mt-2" v-if="errors['image']">
                                            {{ Array.isArray(errors['image']) ? errors['image'][0] : errors['image'] }}
                                        </span>
                                        <img v-if="previewImage" :src="previewImage" alt="preview" style="height: 100px; margin-top: 10px;">
                                        <img v-else-if="slider?.image_url" :src="slider.image_url" alt="current" style="height: 100px; margin-top: 10px;">
                                    </div>
                                </div>

                                <div class="col-md-12 text-center my-4">
                                    <button
                                        type="submit"
                                        class="btn btn-success"
                                        :disabled="loading"
                                    >
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
import { useSliders } from '../../../../composables/useSliders';

declare global {
    interface Window {
        showErrorToast: (message: string) => void;
        showSuccessToast: (message: string) => void;
    }
}

useHead({
    title: 'Update Slider',
});

const router = useRouter();
const route = useRoute();
const { update, getSlider: fetchSlider, slider } = useSliders();

const loading = ref(true);
const errors = reactive<Record<string, any>>({});
const sliderId = ref<string | number>(Array.isArray(route.params.id) ? route.params.id[0] : route.params.id);
const previewImage = ref<string | null>(null);

const formData = reactive({
    title: {
        en: '',
        ar: '',
    },
    desc: {
        en: '',
        ar: '',
    },
    status: true,
    image: null,
});

const loadSlider = async () => {
    try {
        loading.value = true;
        await fetchSlider(sliderId.value);

        if (slider.value) {
            formData.title.en = slider.value.title?.en || '';
            formData.title.ar = slider.value.title?.ar || '';
            formData.desc.en = slider.value.desc?.en || '';
            formData.desc.ar = slider.value.desc?.ar || '';
            formData.status = !!slider.value.status;
        }
    } catch (error: any) {
        const errorMsg = error?.response?.data?.message || 'Failed to load slider';
        window.showErrorToast(errorMsg);
        await router.push('/dash/sliders');
    } finally {
        loading.value = false;
    }
};

const resetErrors = () => {
    Object.keys(errors).forEach(key => {
        delete errors[key];
    });
};

const handleImageChange = (event: any) => {
    const file = event.target.files[0];
    if (file) {
        formData.image = file;
        const reader = new FileReader();
        reader.onload = (e) => {
            previewImage.value = e.target?.result as string;
        };
        reader.readAsDataURL(file);
    }
};

const handleSubmit = async () => {
    resetErrors();
    loading.value = true;

    try {
        const data = new FormData();
        data.append('title[en]', formData.title.en);
        data.append('title[ar]', formData.title.ar);
        data.append('desc[en]', formData.desc.en);
        data.append('desc[ar]', formData.desc.ar);
        data.append('status', formData.status ? '1' : '0');

        if (formData.image) {
            data.append('image', formData.image);
        }

        await update(sliderId.value, data);
        await router.push('/dash/sliders');
    } catch (error: any) {
        if (error?.response?.status === 422) {
            const apiErrors = error?.response?.data?.errors || {};
            Object.assign(errors, apiErrors);
            window.showErrorToast(error?.response?.data?.message || 'Validation error occurred');
        } else {
            const apiErrors = error?.response?.data?.errors || {};
            Object.assign(errors, apiErrors);
            const errorMsg = error?.response?.data?.message || 'Failed to update slider';
            window.showErrorToast(errorMsg);
        }
    } finally {
        loading.value = false;
    }
};

onMounted(() => {
    loadSlider();
});

</script>
