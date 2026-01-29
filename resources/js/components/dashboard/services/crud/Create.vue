<template>
    <div class="text-start my-4">
        <router-link to="/dash/services" class="btn btn-secondary me-2 btn-b">
            <i class="las la-arrow-alt-circle-left"></i>
            Back
        </router-link>
    </div>

    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title text-capitalize">
                    Create Service
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="hidden-columns_wrapper" class="dataTables_wrapper dt-bootstrap5">
                        <form class="container" @submit.prevent="handleSubmit">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Name En</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            :class="{ 'is-invalid': errors['name.en'] }"
                                            v-model="formData.name.en"
                                        >
                                        <span class="text-danger d-block mt-2" v-if="errors['name.en']">
                                            {{ Array.isArray(errors['name.en']) ? errors['name.en'][0] : errors['name.en'] }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Name Ar</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            :class="{ 'is-invalid': errors['name.ar'] }"
                                            v-model="formData.name.ar"
                                        >
                                        <span class="text-danger d-block mt-2" v-if="errors['name.ar']">
                                            {{ Array.isArray(errors['name.ar']) ? errors['name.ar'][0] : errors['name.ar'] }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Description En</label>
                                        <div
                                            class="tiptap-editor"
                                            :class="{ 'is-invalid': errors['description.en'] }"
                                        >
                                            <tiptap-menu-bar :editor="editorEn" />
                                            <editor-content :editor="editorEn" />
                                        </div>
                                        <span class="text-danger d-block mt-2" v-if="errors['description.en']">
                                            {{ Array.isArray(errors['description.en']) ? errors['description.en'][0] : errors['description.en'] }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Description Ar</label>
                                        <div
                                            class="tiptap-editor"
                                            :class="{ 'is-invalid': errors['description.ar'] }"
                                        >
                                            <tiptap-menu-bar :editor="editorAr" />
                                            <editor-content :editor="editorAr" />
                                        </div>
                                        <span class="text-danger d-block mt-2" v-if="errors['description.ar']">
                                            {{ Array.isArray(errors['description.ar']) ? errors['description.ar'][0] : errors['description.ar'] }}
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
                                    </div>
                                </div>

                                <div class="col-md-12 text-center my-4">
                                    <button
                                        type="submit"
                                        class="btn btn-success"
                                        :disabled="loading"
                                    >
                                        {{ loading ? 'Creating...' : 'Create' }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">

import { ref, reactive, onBeforeUnmount } from 'vue';
import { useRouter } from 'vue-router';
import { useHead } from '@vueuse/head';
import { useServices } from '../../../../composables/useServices';
import { useEditor, EditorContent } from '@tiptap/vue-3';
import StarterKit from '@tiptap/starter-kit';
import TiptapMenuBar from '../../../TiptapMenuBar.vue';

// Declare global functions
declare global {
    interface Window {
        showErrorToast: (message: string) => void;
        showSuccessToast: (message: string) => void;
    }
}

useHead({
    title: 'Create Service',
});

const router = useRouter();
const { create } = useServices();

// Reactive state
const loading = ref(false);
const errors = reactive<Record<string, any>>({});
const previewImage = ref<string | null>(null);

const formData = reactive({
    name: {
        en: '',
        ar: '',
    },
    description: {
        en: '',
        ar: '',
    },
    status: true,
    image: null,
});

// TipTap Editor for Description En
const editorEn = useEditor({
    extensions: [StarterKit],
    content: formData.description.en,
    editorProps: {
        attributes: {
            class: 'prose prose-sm focus:outline-none',
        },
    },
    onUpdate: ({ editor }) => {
        formData.description.en = editor.getHTML();
    },
});

// TipTap Editor for Description Ar
const editorAr = useEditor({
    extensions: [StarterKit],
    content: formData.description.ar,
    editorProps: {
        attributes: {
            class: 'prose prose-sm focus:outline-none',
            dir: 'rtl',
        },
    },
    onUpdate: ({ editor }) => {
        formData.description.ar = editor.getHTML();
    },
});

// Cleanup editors on unmount
onBeforeUnmount(() => {
    editorEn.value?.destroy();
    editorAr.value?.destroy();
});

/**
 * Reset form errors
 */
const resetErrors = () => {
    Object.keys(errors).forEach(key => {
        delete errors[key];
    });
};

/**
 * Handle image selection and preview
 */
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

/**
 * Handle form submission
 */
const handleSubmit = async () => {
    resetErrors();
    loading.value = true;

    try {
        // Create FormData for file upload
        const data = new FormData();
        data.append('name[en]', formData.name.en);
        data.append('name[ar]', formData.name.ar);
        data.append('description[en]', formData.description.en);
        data.append('description[ar]', formData.description.ar);
        data.append('status', formData.status ? '1' : '0');

        if (formData.image) {
            data.append('image', formData.image);
        }

        await create(data);
        await router.push('/dash/services');
    } catch (error: any) {
        if (error?.response?.status === 422) {
            const apiErrors = error?.response?.data?.errors || {};
            Object.assign(errors, apiErrors);
            window.showErrorToast(error?.response?.data?.message || 'Validation error occurred');
        } else {
            const apiErrors = error?.response?.data?.errors || {};
            Object.assign(errors, apiErrors);
            const errorMsg = error?.response?.data?.message || 'Failed to create service';
            window.showErrorToast(errorMsg);
        }
    } finally {
        loading.value = false;
    }
};

</script>

<style scoped>
.tiptap-editor {
    border: 1px solid #dee2e6;
    border-radius: 0.25rem;
    min-height: 150px;
    background-color: white;
}

.tiptap-editor.is-invalid {
    border-color: #dc3545;
}

.tiptap-editor :deep(.ProseMirror) {
    outline: none;
    min-height: 120px;
    padding: 0.75rem;
}

.tiptap-editor :deep(.ProseMirror p) {
    margin-bottom: 0.5rem;
}

.tiptap-editor :deep(.ProseMirror p:last-child) {
    margin-bottom: 0;
}

.tiptap-editor :deep(.ProseMirror h1),
.tiptap-editor :deep(.ProseMirror h2),
.tiptap-editor :deep(.ProseMirror h3) {
    margin-top: 0.5rem;
    margin-bottom: 0.5rem;
    font-weight: bold;
}

.tiptap-editor :deep(.ProseMirror h1) {
    font-size: 2rem;
}

.tiptap-editor :deep(.ProseMirror h2) {
    font-size: 1.5rem;
}

.tiptap-editor :deep(.ProseMirror h3) {
    font-size: 1.25rem;
}

.tiptap-editor :deep(.ProseMirror ul),
.tiptap-editor :deep(.ProseMirror ol) {
    padding-left: 1.5rem;
    margin-bottom: 0.5rem;
}

.tiptap-editor :deep(.ProseMirror code) {
    background-color: #f5f5f5;
    padding: 0.2rem 0.4rem;
    border-radius: 0.25rem;
    font-family: monospace;
    font-size: 0.875em;
}

.tiptap-editor :deep(.ProseMirror pre) {
    background-color: #f5f5f5;
    padding: 0.75rem;
    border-radius: 0.25rem;
    overflow-x: auto;
    margin: 0.5rem 0;
}

.tiptap-editor :deep(.ProseMirror pre code) {
    background: none;
    padding: 0;
    font-size: 0.875rem;
}

.tiptap-editor :deep(.ProseMirror blockquote) {
    border-left: 3px solid #dee2e6;
    padding-left: 1rem;
    margin-left: 0;
    margin-top: 0.5rem;
    margin-bottom: 0.5rem;
    font-style: italic;
    color: #6c757d;
}

.tiptap-editor :deep(.ProseMirror hr) {
    border: none;
    border-top: 2px solid #dee2e6;
    margin: 1rem 0;
}
</style>

