import { ref, computed, watch } from 'vue';
// @ts-ignore
import { useUsersStore } from '@/stores/users';

interface QueryParams {
    page?: number;
    per_page?: number;
    sortBy?: string;
    sortDesc?: string;
    search?: string;
}

export const useUsers = () => {
    const store = useUsersStore();

    // Local state
    const page = ref(1);
    const itemsPerPage = ref(50);
    const sortBy = ref('id');
    const sortDesc = ref('desc');
    const searchQuery = ref('');

    // Computed properties from store
    const users = computed(() => store.getUsers);
    const user = computed(() => store.getUser);
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
     * Fetch users list
     */
    const fetchUsers = async () => {
        await store.fetchUsers(buildQueryParams());
    };

    /**
     * Fetch single user by ID
     */
    const getUser = async (id: number) => {
        await store.fetchUser(id);
    };

    /**
     * Create new user
     */
    const create = async (data: object) => {
        return await store.createUser(data);
    };

    /**
     * Update user
     */
    const update = async (id: number, data: object) => {
        return await store.updateUser(id, data);
    };

    /**
     * Delete user
     */
    const delete_ = async (id: number) => {
        return await store.deleteUser(id);
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

        fetchUsers();
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
        fetchUsers();
    });

    return {
        // State
        page,
        itemsPerPage,
        sortBy,
        sortDesc,
        searchQuery,
        // Computed
        users,
        user,
        meta,
        loading,
        error,
        totalCount,
        // Methods
        fetchUsers,
        getUser,
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
