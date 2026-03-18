import { ref, computed, watch } from 'vue';
// @ts-ignore
import { useItemsStore } from '@/stores/items';

interface QueryParams {
    page?: number;
    per_page?: number;
    sortBy?: string;
    sortDesc?: string;
    search?: string;
}

export const useItems = () => {
    const store = useItemsStore();

    const page = ref(1);
    const itemsPerPage = ref(50);
    const sortBy = ref('id');
    const sortDesc = ref('desc');
    const searchQuery = ref('');

    const items = computed(() => store.getItems);
    const item = computed(() => store.getItem);
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

    const fetchItems = async () => {
        await store.fetchItems(buildQueryParams());
    };

    const getItem = async (id: number) => {
        await store.fetchItem(id);
    };

    const create = async (data: object) => {
        return await store.createItem(data);
    };

    const update = async (id: number, data: object) => {
        return await store.updateItem(id, data);
    };

    const delete_ = async (id: number) => {
        return await store.deleteItem(id);
    };

    const handleTableOptionsChange = ({ page: newPage, itemsPerPage: newPerPage, sortBy: newSortBy }: any) => {
        page.value = newPage || 1;
        itemsPerPage.value = newPerPage || 50;

        if (newSortBy && newSortBy.length > 0) {
            sortBy.value = newSortBy[0].key;
            sortDesc.value = newSortBy[0].order === 'desc' ? 'desc' : 'asc';
        }

        fetchItems();
    };

    watch(searchQuery, () => {
        page.value = 1;
        fetchItems();
    });

    return {
        page,
        itemsPerPage,
        sortBy,
        sortDesc,
        searchQuery,
        items,
        item,
        meta,
        loading,
        error,
        totalCount,
        fetchItems,
        getItem,
        create,
        update,
        delete_,
        handleTableOptionsChange,
    };
};

