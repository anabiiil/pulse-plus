import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import axios from "axios";

interface Coupon {
    id: number;
    code: string;
    name: string | null;
    type: string;
    type_label?: string;
    value: number;
    starts_at?: string | null;
    expires_at?: string | null;
    is_redeemable?: boolean;
    status: number | string;
    orders_count?: number;
    created_at: string;
}

interface PaginationMeta {
    total: number;
    to: number;
    from: number;
    per_page: number;
    last_page: number;
    current_page: number;
}

export const useCouponsStore = defineStore('coupons', () => {
    // State
    const coupons = ref<Coupon[]>([]);
    const coupon = ref<Coupon | null>(null);
    const statistics = ref<Record<string, any> | null>(null);
    const orders = ref<any[]>([]);
    const ordersMeta = ref<PaginationMeta | null>(null);
    const meta = ref<PaginationMeta | null>(null);
    const loading = ref<boolean>(false);
    const error = ref<string | null>(null);

    // Getters
    const getCoupons = computed(() => coupons.value);
    const getCoupon = computed(() => coupon.value);
    const getStatistics = computed(() => statistics.value);
    const getOrders = computed(() => orders.value);
    const getOrdersMeta = computed(() => ordersMeta.value);
    const getMeta = computed(() => meta.value);
    const isLoading = computed(() => loading.value);
    const getError = computed(() => error.value);
    const getTotalCount = computed(() => meta.value?.total || 0);

    const parseMeta = (response: any): PaginationMeta => ({
        total: response.data.pagination?.meta?.page?.total || 0,
        to: response.data.pagination?.meta?.page?.to || 0,
        from: response.data.pagination?.meta?.page?.from || 0,
        per_page: response.data.pagination?.meta?.page?.per_page || 50,
        last_page: response.data.pagination?.meta?.page?.last_page || 1,
        current_page: response.data.pagination?.meta?.page?.current_page || 1,
    });

    /**
     * Fetch coupons list with filters and pagination
     */
    const fetchCoupons = async (queryParams: object = {}) => {
        try {
            loading.value = true;
            error.value = null;

            const response = await axios.get('/coupons', { params: queryParams });

            coupons.value = response.data.data || [];
            meta.value = parseMeta(response);
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to fetch coupons';
            console.error('Error fetching coupons:', err);
        } finally {
            loading.value = false;
        }
    };

    /**
     * Fetch single coupon with its statistics
     */
    const fetchCoupon = async (id: number) => {
        try {
            loading.value = true;
            error.value = null;

            const response = await axios.get(`/coupons/${id}`);
            coupon.value = response.data.data?.coupon || null;
            statistics.value = response.data.data?.statistics || null;
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to fetch coupon';
            console.error('Error fetching coupon:', err);
        } finally {
            loading.value = false;
        }
    };

    /**
     * Fetch a coupon's completed orders (paginated)
     */
    const fetchCouponOrders = async (id: number, queryParams: object = {}) => {
        try {
            const response = await axios.get(`/coupons/${id}/orders`, { params: queryParams });
            orders.value = response.data.data || [];
            ordersMeta.value = parseMeta(response);
        } catch (err: any) {
            console.error('Error fetching coupon orders:', err);
        }
    };

    /**
     * Create a new coupon
     */
    const createCoupon = async (data: object) => {
        try {
            loading.value = true;
            error.value = null;

            const response = await axios.post('/coupons', data);
            coupon.value = response.data.data || null;

            if (response.data.data) {
                coupons.value.unshift(response.data.data);
            }

            return response.data;
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to create coupon';
            throw err;
        } finally {
            loading.value = false;
        }
    };

    /**
     * Update existing coupon
     */
    const updateCoupon = async (id: number, data: object) => {
        try {
            loading.value = true;
            error.value = null;

            const response = await axios.patch(`/coupons/${id}`, data);
            coupon.value = response.data.data || null;

            const index = coupons.value.findIndex((c) => c.id === id);
            if (index !== -1 && response.data.data) {
                coupons.value[index] = response.data.data;
            }

            return response.data;
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to update coupon';
            throw err;
        } finally {
            loading.value = false;
        }
    };

    /**
     * Delete a coupon
     */
    const deleteCoupon = async (id: number) => {
        try {
            loading.value = true;
            error.value = null;

            const response = await axios.delete(`/coupons/${id}`);

            coupons.value = coupons.value.filter((c) => c.id !== id);
            coupon.value = null;

            return response.data;
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to delete coupon';
            throw err;
        } finally {
            loading.value = false;
        }
    };

    const clearState = () => {
        coupons.value = [];
        coupon.value = null;
        statistics.value = null;
        orders.value = [];
        meta.value = null;
        error.value = null;
    };

    return {
        // State
        coupons,
        coupon,
        statistics,
        orders,
        ordersMeta,
        meta,
        loading,
        error,
        // Getters
        getCoupons,
        getCoupon,
        getStatistics,
        getOrders,
        getOrdersMeta,
        getMeta,
        isLoading,
        getError,
        getTotalCount,
        // Actions
        fetchCoupons,
        fetchCoupon,
        fetchCouponOrders,
        createCoupon,
        updateCoupon,
        deleteCoupon,
        clearState,
    };
});
