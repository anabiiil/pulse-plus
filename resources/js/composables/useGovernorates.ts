import { ref, computed, watch } from 'vue';
// @ts-ignore
import { useGovernoratesStore } from '@/stores/governorates';

interface QueryParams {
    page?: number;
    per_page?: number;
    sortBy?: string;
    sortDesc?: string;
    search?: string;
}

export const useGovernorates = () => {
    const store = useGovernoratesStore();

    // Local state
    const page = ref(1);
    const itemsPerPage = ref(50);
    const sortBy = ref('id');
    const sortDesc = ref('desc');
    const searchQuery = ref('');

    // Computed properties from store
    const governorates = computed(() => store.getGovernorates);
    const governorate = computed(() => store.getGovernorate);
    const meta = computed(() => store.getMeta);
    const loading = computed(() => store.isLoading);
    const error = computed(() => store.getError);
    const totalCount = computed(() => store.getTotalCount);

    /**
     * Build query parameters for API call
     */
    const buildQueryParams = (): QueryParams => {
        return {
            page: page.value,
            per_page: itemsPerPage.value,
            sortBy: sortBy.value,
            sortDesc: sortDesc.value,
            search: searchQuery.value,
        };
    };

    /**
     * Fetch governorates list
     */
    const fetchGovernorates = async () => {
        await store.fetchGovernorates(buildQueryParams());
    };

    /**
     * Fetch single governorate by ID
     */
    const getGovernorate = async (id: number) => {
        await store.fetchGovernorate(id);
    };

    /**
     * Create new governorate
     */
    const create = async (data: object) => {
        return await store.createGovernorate(data);
    };

    /**
     * Update governorate
     */
    const update = async (id: number, data: object) => {
        return await store.updateGovernorate(id, data);
    };

    /**
     * Delete governorate
     */
    const delete_ = async (id: number) => {
        return await store.deleteGovernorate(id);
    };

    /**
     * Update pagination
     */
    const setPagination = (newPage: number, newItemsPerPage: number) => {
        page.value = newPage;
        itemsPerPage.value = newItemsPerPage;
    };

    /**
     * Update sorting
     */
    const setSorting = (field: string, order: string) => {
        sortBy.value = field;
        sortDesc.value = order;
    };

    /**
     * Update search query
     */
    const setSearch = (query: string) => {
        searchQuery.value = query;
        page.value = 1; // Reset to first page on search
    };

    /**
     * Handle table options change
     */
    const handleTableOptionsChange = (options: any) => {
        page.value = options.page || 1;
        itemsPerPage.value = options.itemsPerPage || 50;

        if (options.sortBy?.length > 0) {
            sortBy.value = options.sortBy[0].key;
            sortDesc.value = options.sortBy[0].order;
        }

        fetchGovernorates();
    };

    /**
     * Reset all filters and pagination
     */
    const reset = () => {
        page.value = 1;
        itemsPerPage.value = 50;
        sortBy.value = 'id';
        sortDesc.value = 'desc';
        searchQuery.value = '';
        store.clearState();
    };

    /**
     * Watch search query and refetch
     */
    watch(searchQuery, () => {
        page.value = 1;
        fetchGovernorates();
    });

    return {
        // State
        page,
        itemsPerPage,
        sortBy,
        sortDesc,
        searchQuery,
        // Computed
        governorates,
        governorate,
        meta,
        loading,
        error,
        totalCount,
        // Methods
        fetchGovernorates,
        getGovernorate,
        create,
        update,
        delete: delete_,
        setPagination,
        setSorting,
        setSearch,
        handleTableOptionsChange,
        reset,
    };
};
