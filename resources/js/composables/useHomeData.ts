import { ref } from 'vue';
import axios from 'axios';

interface Slider {
    id: number;
    title: string;
    description: string;
    image_url: string;
    link?: string;
    status: string;
    created_at: string;
}

interface Product {
    id: number;
    name: string;
    description: string;
    image_url: string;
    status: string;
    created_at: string;
    updated_at: string;
}

interface Service {
    id: number;
    name: string;
    description: string;
    image_url: string;
    status: string;
    created_at: string;
    updated_at: string;
}

interface HomeData {
    sliders: Slider[];
    products: Product[];
    services: Service[];
}

export const useHomeData = () => {
    const homeData = ref<HomeData | null>(null);
    const loading = ref(false);
    const error = ref<string | null>(null);

    /**
     * Fetch home page data
     */
    const fetchHomeData = async (params?: {
        slider_limit?: number;
        product_limit?: number;
        service_limit?: number;
    }): Promise<void> => {
        try {
            loading.value = true;
            error.value = null;

            const response = await axios.get('/api/website/home', {
                params: params || {}
            });

            homeData.value = response.data.data;
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to fetch home data';
            console.error('Error fetching home data:', err);
            throw err;
        } finally {
            loading.value = false;
        }
    };

    return {
        homeData,
        loading,
        error,
        fetchHomeData,
    };
};

