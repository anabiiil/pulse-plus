import { ref, computed, watch } from 'vue';
// @ts-ignore
import { useNationalitiesStore } from '@/stores/nationalities';

interface QueryParams {
    page?: number;
    per_page?: number;
    sortBy?: string;
    sortDesc?: string;
    search?: string;
}

export const useNationalities = () => {
    const store = useNationalitiesStore();

    // Local state
    const page = ref(1);
    const itemsPerPage = ref(50);
    const sortBy = ref('id');
    const sortDesc = ref('desc');
    const searchQuery = ref('');

    // Computed properties from store
    const nationalities = computed(() => store.getNationalities);
    const nationality = computed(() => store.getNationality);
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
     * Fetch nationalities list
     */
    const fetchNationalities = async () => {
        await store.fetchNationalities(buildQueryParams());
    };

    /**
     * Fetch single nationality by ID
     */
    const getNationality = async (id: number) => {
        await store.fetchNationality(id);
    };

    /**
     * Create new nationality
     */
    const create = async (data: object) => {
        return await store.createNationality(data);
    };

    /**
     * Update nationality
     */
    const update = async (id: number, data: object) => {
        return await store.updateNationality(id, data);
    };

    /**
     * Delete nationality
     */
    const delete_ = async (id: number) => {
        return await store.deleteNationality(id);
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

        fetchNationalities();
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
        fetchNationalities();
    });

    return {
        // State
        page,
        itemsPerPage,
        sortBy,
        sortDesc,
        searchQuery,
        // Computed
        nationalities,
        nationality,
        meta,
        loading,
        error,
        totalCount,
        // Methods
        fetchNationalities,
        getNationality,
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
