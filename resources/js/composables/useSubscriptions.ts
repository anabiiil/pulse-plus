import { ref, computed, watch } from 'vue';
// @ts-ignore
import { useSubscriptionsStore } from '@/stores/subscriptions';

interface QueryParams {
    page?: number;
    per_page?: number;
    sortBy?: string;
    sortDesc?: string;
    search?: string;
}

export const useSubscriptions = () => {
    const store = useSubscriptionsStore();

    const page = ref(1);
    const itemsPerPage = ref(50);
    const sortBy = ref('id');
    const sortDesc = ref('desc');
    const searchQuery = ref('');

    const subscriptions = computed(() => store.getSubscriptions);
    const subscription = computed(() => store.getSubscription);
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

    const fetchSubscriptions = async () => {
        await store.fetchSubscriptions(buildQueryParams());
    };

    const getSubscription = async (id: number) => {
        await store.fetchSubscription(id);
    };

    const create = async (data: object) => {
        return await store.createSubscription(data);
    };

    const update = async (id: number, data: object) => {
        return await store.updateSubscription(id, data);
    };

    const delete_ = async (id: number) => {
        return await store.deleteSubscription(id);
    };

    const handleTableOptionsChange = (options: any) => {
        page.value = options.page || 1;
        itemsPerPage.value = options.itemsPerPage || 50;

        if (options.sortBy?.length > 0) {
            sortBy.value = options.sortBy[0].key;
            sortDesc.value = options.sortBy[0].order;
        }

        fetchSubscriptions();
    };

    const reset = () => {
        page.value = 1;
        itemsPerPage.value = 50;
        sortBy.value = 'id';
        sortDesc.value = 'desc';
        searchQuery.value = '';
        store.clearState();
    };

    watch(searchQuery, () => {
        page.value = 1;
        fetchSubscriptions();
    });

    return {
        page,
        itemsPerPage,
        sortBy,
        sortDesc,
        searchQuery,
        subscriptions,
        subscription,
        meta,
        loading,
        error,
        totalCount,
        fetchSubscriptions,
        getSubscription,
        create,
        update,
        delete: delete_,
        handleTableOptionsChange,
        reset,
    };
};

