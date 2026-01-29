<template>
    <div class="text-start my-4">
        <router-link to="/dash/users" class="btn btn-secondary me-2 btn-b">
            <i class="las la-arrow-alt-circle-left"></i>
            Back
        </router-link>
    </div>
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title text-capitalize">
                    Delete User
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="hidden-columns_wrapper" class="dataTables_wrapper dt-bootstrap5">
                        <form class="container" @submit.prevent="handleDelete" v-if="!loading">
                            <div class="row">
                                <div class="col-12 my-4">
                                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                                        <svg class="flex-shrink-0 me-2 svg-danger" xmlns="http://www.w3.org/2000/svg"
                                             enable-background="new 0 0 24 24" height="1.5rem" viewBox="0 0 24 24"
                                             width="1.5rem" fill="#000000">
                                            <g><rect fill="none" height="24" width="24"></rect></g>
                                            <g>
                                                <g>
                                                    <g>
                                                        <path d="M15.73,3H8.27L3,8.27v7.46L8.27,21h7.46L21,15.73V8.27L15.73,3z M19,14.9L14.9,19H9.1L5,14.9V9.1L9.1,5h5.8L19,9.1V14.9z"></path>
                                                        <rect height="6" width="2" x="11" y="7"></rect>
                                                        <rect height="2" width="2" x="11" y="15"></rect>
                                                    </g>
                                                </g>
                                            </g>
                                        </svg>
                                        <div>
                                            Are you sure you want to delete user <strong>{{ user?.name }}</strong>? This action cannot be undone.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 text-center my-4">
                                    <button type="submit" class="btn btn-danger" :disabled="deleting">
                                        {{ deleting ? 'Deleting...' : 'Delete' }}
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
import { ref, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useHead } from '@vueuse/head';
import { useUsers } from '../../../../composables/useUsers';

declare global {
    interface Window {
        showErrorToast: (message: string) => void;
    }
}

useHead({ title: 'Delete User' });

const router = useRouter();
const route = useRoute();
const { delete: deleteUser, getUser, user } = useUsers();

const loading = ref(true);
const deleting = ref(false);
const userId = ref<string | number>(Array.isArray(route.params.id) ? route.params.id[0] : route.params.id);

const loadUser = async () => {
    try {
        loading.value = true;
        await getUser(userId.value);

        if (!user.value) {
            window.showErrorToast('User not found');
            await router.push('/dash/users');
        }
    } catch (error: any) {
        const errorMsg = error?.response?.data?.message || 'Failed to load user';
        window.showErrorToast(errorMsg);
        await router.push('/dash/users');
    } finally {
        loading.value = false;
    }
};

const handleDelete = async () => {
    deleting.value = true;

    try {
        await deleteUser(userId.value);
        await router.push('/dash/users');
    } catch (error: any) {
        const errorMsg = error?.response?.data?.message || 'Failed to delete user';
        window.showErrorToast(errorMsg);
    } finally {
        deleting.value = false;
    }
};

onMounted(() => {
    loadUser();
});
</script>
