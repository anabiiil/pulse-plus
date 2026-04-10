import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import axios from 'axios';

interface Subscription {
    id: number;
    name: string;
    months: number;
    status: boolean;
    description: string | null;
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

export const useSubscriptionsStore = defineStore('subscriptions', () => {
    const subscriptions = ref<Subscription[]>([]);
    const subscription = ref<Subscription | null>(null);
    const meta = ref<PaginationMeta | null>(null);
    const loading = ref<boolean>(false);
    const error = ref<string | null>(null);

    const getSubscriptions = computed(() => subscriptions.value);
    const getSubscription = computed(() => subscription.value);
    const getMeta = computed(() => meta.value);
    const isLoading = computed(() => loading.value);
    const getError = computed(() => error.value);
    const getTotalCount = computed(() => meta.value?.total || 0);

    const fetchSubscriptions = async (queryParams: object = {}) => {
        try {
            loading.value = true;
            error.value = null;

            const response = await axios.get('/subscriptions', { params: queryParams });

            subscriptions.value = response.data.data || [];
            meta.value = {
                total: response.data.pagination?.meta?.page?.total || 0,
                to: response.data.pagination?.meta?.page?.to || 0,
                from: response.data.pagination?.meta?.page?.from || 0,
                per_page: response.data.pagination?.meta?.page?.per_page || 50,
                last_page: response.data.pagination?.meta?.page?.last_page || 1,
                current_page: response.data.pagination?.meta?.page?.current_page || 1,
            };
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to fetch subscriptions';
            console.error('Error fetching subscriptions:', err);
        } finally {
            loading.value = false;
        }
    };

    const fetchSubscription = async (id: number) => {
        try {
            loading.value = true;
            error.value = null;

            const response = await axios.get(`/subscriptions/${id}`);
            subscription.value = response.data.data || null;
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to fetch subscription';
            console.error('Error fetching subscription:', err);
        } finally {
            loading.value = false;
        }
    };

    const createSubscription = async (data: object) => {
        try {
            loading.value = true;
            error.value = null;

            const response = await axios.post('/subscriptions', data);
            subscription.value = response.data.data || null;

            if (response.data.data) {
                subscriptions.value.unshift(response.data.data);
            }

            return response.data;
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to create subscription';
            console.error('Error creating subscription:', err);
            throw err;
        } finally {
            loading.value = false;
        }
    };

    const updateSubscription = async (id: number, data: object) => {
        try {
            loading.value = true;
            error.value = null;

            const response = await axios.put(`/subscriptions/${id}`, data);
            subscription.value = response.data.data || null;

            const index = subscriptions.value.findIndex((s) => s.id === id);
            if (index !== -1 && response.data.data) {
                subscriptions.value[index] = response.data.data;
            }

            return response.data;
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to update subscription';
            console.error('Error updating subscription:', err);
            throw err;
        } finally {
            loading.value = false;
        }
    };

    const deleteSubscription = async (id: number) => {
        try {
            loading.value = true;
            error.value = null;

            const response = await axios.delete(`/subscriptions/${id}`);
            subscriptions.value = subscriptions.value.filter((s) => s.id !== id);
            subscription.value = null;

            return response.data;
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to delete subscription';
            console.error('Error deleting subscription:', err);
            throw err;
        } finally {
            loading.value = false;
        }
    };

    const clearState = () => {
        subscriptions.value = [];
        subscription.value = null;
        meta.value = null;
        error.value = null;
    };

    return {
        subscriptions,
        subscription,
        meta,
        loading,
        error,
        getSubscriptions,
        getSubscription,
        getMeta,
        isLoading,
        getError,
        getTotalCount,
        fetchSubscriptions,
        fetchSubscription,
        createSubscription,
        updateSubscription,
        deleteSubscription,
        clearState,
    };
});

