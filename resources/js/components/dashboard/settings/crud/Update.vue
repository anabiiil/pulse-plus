<template>
    <div class="text-start my-4">
        <router-link to="/dash/settings" class="btn btn-secondary me-2 btn-b">
            <i class="las la-arrow-alt-circle-left"></i>
            Back
        </router-link>
    </div>

    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title text-capitalize">
                    Update Setting
                    <span v-if="formData?.slug" class="badge bg-secondary ms-2">{{ formData.slug }}</span>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="hidden-columns_wrapper" class="dataTables_wrapper dt-bootstrap5">
                        <form class="container" @submit.prevent="handleSubmit" v-if="!loading">
                            <div class="row">
                                <!-- Title English -->
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Title (English)</label>
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

                                <!-- Title Arabic -->
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Title (Arabic)</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            :class="{ 'is-invalid': errors['title.ar'] }"
                                            v-model="formData.title.ar"
                                            dir="rtl"
                                        >
                                        <span class="text-danger d-block mt-2" v-if="errors['title.ar']">
                                            {{ Array.isArray(errors['title.ar']) ? errors['title.ar'][0] : errors['title.ar'] }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Slug (Read-only) -->
                                <div class="col-lg-12">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Slug (Key Identifier)</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="formData.slug"
                                            readonly
                                            disabled
                                        >
                                        <small class="text-muted">This is the unique identifier and cannot be changed</small>
                                    </div>
                                </div>

                                <!-- Content English -->
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Content (English)</label>
                                        <textarea
                                            class="form-control"
                                            :class="{ 'is-invalid': errors['content.en'] }"
                                            v-model="formData.content.en"
                                            rows="10"
                                            placeholder="Enter content in English..."
                                        ></textarea>
                                        <span class="text-danger d-block mt-2" v-if="errors['content.en']">
                                            {{ Array.isArray(errors['content.en']) ? errors['content.en'][0] : errors['content.en'] }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Content Arabic -->
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Content (Arabic)</label>
                                        <textarea
                                            class="form-control"
                                            :class="{ 'is-invalid': errors['content.ar'] }"
                                            v-model="formData.content.ar"
                                            rows="10"
                                            dir="rtl"
                                            placeholder="أدخل المحتوى بالعربية..."
                                        ></textarea>
                                        <span class="text-danger d-block mt-2" v-if="errors['content.ar']">
                                            {{ Array.isArray(errors['content.ar']) ? errors['content.ar'][0] : errors['content.ar'] }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="col-md-12 text-center my-4">
                                    <button
                                        type="submit"
                                        class="btn btn-success"
                                        :disabled="submitting"
                                    >
                                        <span v-if="submitting">
                                            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                            Updating...
                                        </span>
                                        <span v-else>
                                            <i class="fe fe-save me-2"></i>
                                            Update Setting
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- Loading State -->
                        <div v-else class="text-center py-5">
                            <v-progress-circular indeterminate color="primary" size="64"></v-progress-circular>
                            <p class="mt-3 text-muted">Loading setting...</p>
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
import { useSettings } from '../../../../composables/useSettings';

// Declare global functions
declare global {
    interface Window {
        showErrorToast: (message: string) => void;
        showSuccessToast: (message: string) => void;
    }
}

useHead({
    title: 'Update Setting',
});

const router = useRouter();
const route = useRoute();
const { update, getSetting, setting } = useSettings();

// Reactive state
const loading = ref(true);
const submitting = ref(false);
const errors = reactive<Record<string, any>>({});
const settingId = ref(Number(route.params.id));

const formData = reactive({
    title: {
        en: '',
        ar: '',
    },
    slug: '',
    content: {
        en: '',
        ar: '',
    },
});

/**
 * Load setting data on mount
 */
const loadSetting = async () => {
    try {
        loading.value = true;
        await getSetting(settingId.value);

        if (setting.value) {
            formData.title.en = setting.value.title?.en || '';
            formData.title.ar = setting.value.title?.ar || '';
            formData.slug = setting.value.slug || '';
            formData.content.en = setting.value.content?.en || '';
            formData.content.ar = setting.value.content?.ar || '';
        }
    } catch (error: any) {
        const errorMsg = error?.response?.data?.message || 'Failed to load setting';
        window.showErrorToast(errorMsg);
        await router.push('/dash/settings');
    } finally {
        loading.value = false;
    }
};

/**
 * Reset form errors
 */
const resetErrors = () => {
    Object.keys(errors).forEach(key => {
        delete errors[key];
    });
};

/**
 * Handle form submission
 */
const handleSubmit = async () => {
    resetErrors();
    submitting.value = true;

    try {
        const data = {
            title: {
                en: formData.title.en,
                ar: formData.title.ar,
            },
            slug: formData.slug,
            content: {
                en: formData.content.en,
                ar: formData.content.ar,
            },
        };

        await update(settingId.value, data);
        window.showSuccessToast('Setting updated successfully!');
        await router.push('/dash/settings');
    } catch (error: any) {
        if (error?.response?.status === 422) {
            const apiErrors = error?.response?.data?.errors || {};
            Object.assign(errors, apiErrors);
            window.showErrorToast(error?.response?.data?.message || 'Validation error occurred');
        } else {
            const apiErrors = error?.response?.data?.errors || {};
            Object.assign(errors, apiErrors);
            const errorMsg = error?.response?.data?.message || 'Failed to update setting';
            window.showErrorToast(errorMsg);
        }
    } finally {
        submitting.value = false;
    }
};

onMounted(() => {
    loadSetting();
});

</script>

<style scoped>
textarea.form-control {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    font-size: 0.95rem;
    line-height: 1.6;
}

textarea[dir="rtl"] {
    font-family: 'Arial', sans-serif;
}

.badge {
    font-size: 0.875rem;
    font-weight: 500;
}

.spinner-border-sm {
    width: 1rem;
    height: 1rem;
    border-width: 0.2em;
}
</style>


