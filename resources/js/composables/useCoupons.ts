import { ref, computed, watch } from 'vue';
// @ts-ignore
import { useCouponsStore } from '@/stores/coupons';

interface QueryParams {
    page?: number;
    per_page?: number;
    sortBy?: string;
    sortDesc?: string;
    search?: string;
}

export const useCoupons = () => {
    const store = useCouponsStore();

    // Local state
    const page = ref(1);
    const itemsPerPage = ref(50);
    const sortBy = ref('id');
    const sortDesc = ref('desc');
    const searchQuery = ref('');

    // Computed properties from store
    const coupons = computed(() => store.getCoupons);
    const coupon = computed(() => store.getCoupon);
    const statistics = computed(() => store.getStatistics);
    const orders = computed(() => store.getOrders);
    const ordersMeta = computed(() => store.getOrdersMeta);
    const meta = computed(() => store.getMeta);
    const loading = computed(() => store.isLoading);
    const error = computed(() => store.getError);
    const totalCount = computed(() => store.getTotalCount);

    const buildQueryParams = (): QueryParams => ({
        page: page.value,
        per_page: itemsPerPage.value,
        sortBy: sortBy.value,
        sortDesc: sortDesc.value,
        search: searchQuery.value,
    });

    const fetchCoupons = async () => {
        await store.fetchCoupons(buildQueryParams());
    };

    const getCoupon = async (id: number) => {
        await store.fetchCoupon(id);
    };

    const getCouponOrders = async (id: number, params: object = {}) => {
        await store.fetchCouponOrders(id, params);
    };

    const create = async (data: object) => {
        return await store.createCoupon(data);
    };

    const update = async (id: number, data: object) => {
        return await store.updateCoupon(id, data);
    };

    const delete_ = async (id: number) => {
        return await store.deleteCoupon(id);
    };

    const handleTableOptionsChange = (options: any) => {
        page.value = options.page || 1;
        itemsPerPage.value = options.itemsPerPage || 50;

        if (options.sortBy?.length > 0) {
            sortBy.value = options.sortBy[0].key;
            sortDesc.value = options.sortBy[0].order;
        }

        fetchCoupons();
    };

    watch(searchQuery, () => {
        page.value = 1;
        fetchCoupons();
    });

    return {
        // State
        page,
        itemsPerPage,
        sortBy,
        sortDesc,
        searchQuery,
        // Computed
        coupons,
        coupon,
        statistics,
        orders,
        ordersMeta,
        meta,
        loading,
        error,
        totalCount,
        // Methods
        fetchCoupons,
        getCoupon,
        getCouponOrders,
        create,
        update,
        delete: delete_,
        handleTableOptionsChange,
    };
};
