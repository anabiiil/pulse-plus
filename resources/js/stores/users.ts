import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import axios from "axios";

interface User {
    id: number;
    name: string;
    email: string;
    phone?: string;
    address?: string;
    birthdate?: string;
    gender?: string;
    marital_status?: string;
    country_id?: number;
    country?: any;
    status: string;
    hash_url?: string;
    qr_code?: string;
    qr_code_path?: string;
    created_at: string;
    updated_at: string;
}

interface PaginationMeta {
    total: number;
    to: number;
    from: number;
    per_page: number;
    last_page: number;
    current_page: number;
}

export const useUsersStore = defineStore('users', () => {
    // State
    const users = ref<User[]>([]);
    const user = ref<User | null>(null);
    const meta = ref<PaginationMeta | null>(null);
    const loading = ref<boolean>(false);
    const error = ref<string | null>(null);

    // Getters
    const getUsers = computed(() => users.value);
    const getUser = computed(() => user.value);
    const getMeta = computed(() => meta.value);
    const isLoading = computed(() => loading.value);
    const getError = computed(() => error.value);
    const getTotalCount = computed(() => meta.value?.total || 0);

    // Actions
    /**
     * Fetch users list with filters and pagination
     */
    const fetchUsers = async (queryParams: object = {}) => {
        try {
            loading.value = true;
            error.value = null;

            const response = await axios.get('/users', {
                params: queryParams,
            });

            users.value = response.data.data || [];
            meta.value = {
                total: response.data.pagination?.meta?.page?.total || 0,
                to: response.data.pagination?.meta?.page?.to || 0,
                from: response.data.pagination?.meta?.page?.from || 0,
                per_page: response.data.pagination?.meta?.page?.per_page || 50,
                last_page: response.data.pagination?.meta?.page?.last_page || 1,
                current_page: response.data.pagination?.meta?.page?.current_page || 1,
            };
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to fetch users';
            console.error('Error fetching users:', err);
        } finally {
            loading.value = false;
        }
    };

    /**
     * Fetch single user by ID
     */
    const fetchUser = async (id: number) => {
        try {
            loading.value = true;
            error.value = null;

            const response = await axios.get(`/users/${id}`);
            user.value = response.data.data || null;
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to fetch user';
            console.error('Error fetching user:', err);
        } finally {
            loading.value = false;
        }
    };

    /**
     * Create a new user
     */
    const createUser = async (data: object) => {
        try {
            loading.value = true;
            error.value = null;

            const response = await axios.post('/users', data);
            user.value = response.data.data || null;

            // Add new user to list
            if (response.data.data) {
                users.value.unshift(response.data.data);
            }

            return response.data;
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to create user';
            console.error('Error creating user:', err);
            throw err;
        } finally {
            loading.value = false;
        }
    };

    /**
     * Update existing user
     */
    const updateUser = async (id: number, data: object) => {
        try {
            loading.value = true;
            error.value = null;

            const response = await axios.put(`/users/${id}`, data);
            user.value = response.data.data || null;

            // Update in list
            const index = users.value.findIndex((u) => u.id === id);
            if (index !== -1 && response.data.data) {
                users.value[index] = response.data.data;
            }

            return response.data;
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to update user';
            console.error('Error updating user:', err);
            throw err;
        } finally {
            loading.value = false;
        }
    };

    /**
     * Delete a user
     */
    const deleteUser = async (id: number) => {
        try {
            loading.value = true;
            error.value = null;

            const response = await axios.delete(`/users/${id}`);

            // Remove from list
            users.value = users.value.filter((u) => u.id !== id);
            user.value = null;

            return response.data;
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to delete user';
            console.error('Error deleting user:', err);
            throw err;
        } finally {
            loading.value = false;
        }
    };

    /**
     * Clear store state
     */
    const clearState = () => {
        users.value = [];
        user.value = null;
        meta.value = null;
        error.value = null;
    };

    /**
     * Clear error message
     */
    const clearError = () => {
        error.value = null;
    };

    return {
        // State
        users,
        user,
        meta,
        loading,
        error,
        // Getters
        getUsers,
        getUser,
        getMeta,
        isLoading,
        getError,
        getTotalCount,
        // Actions
        fetchUsers,
        fetchUser,
        createUser,
        updateUser,
        deleteUser,
        clearState,
        clearError,
    };
});
