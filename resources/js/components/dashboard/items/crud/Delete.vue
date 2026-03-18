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
                <div class="card-title text-danger">Delete Item</div>
            </div>
            <div class="card-body text-center py-5">
                <i class="fe fe-alert-triangle text-danger" style="font-size: 3rem;"></i>
                <h4 class="mt-3 mb-2">Are you sure you want to delete this item?</h4>
                <p class="text-muted mb-1">
                    <strong>Name:</strong>
                    <span v-if="item?.name">{{ item.name }}</span>
                    <em v-else>—</em>
                </p>
                <p class="text-muted mb-4">
                    <strong>UUID:</strong> <code>{{ item?.uuid }}</code>
                </p>
                <p class="text-danger fw-semibold">This action cannot be undone.</p>

                <div class="d-flex justify-content-center gap-3 mt-4">
                    <button class="btn btn-danger" :disabled="loading" @click="handleDelete">
                        {{ loading ? 'Deleting...' : 'Yes, Delete' }}
                    </button>
                    <router-link to="/dash/items" class="btn btn-secondary">
                        Cancel
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { onMounted } from 'vue';
import { useHead } from '@vueuse/head';
import { useRouter } from 'vue-router';
import { useItems } from '../../../../composables/useItems';
// @ts-ignore
import { useToast } from 'vue-toastification';

const props = defineProps<{ id: string }>();

useHead({ title: 'Delete Item' });

const router = useRouter();
const toast = useToast();
const { loading, getItem, delete_, item } = useItems();

const handleDelete = async () => {
    try {
        await delete_(Number(props.id));
        toast.success('Item deleted successfully');
        router.push('/dash/items');
    } catch {
        toast.error('Failed to delete item');
    }
};

onMounted(async () => {
    await getItem(Number(props.id));
});
</script>

