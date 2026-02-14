import { ref, computed } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

interface User {
    id: number;
    name: string;
    email: string;
    phone?: string | null;
    emergency_phone?: string | null;
    display_emergency?: boolean;
    birthdate?: string | null;
    gender?: string | null;
    address?: string | null;
    country_id?: number | null;
    marital_status?: string | null;
    profile_image_url?: string | null;
    hash_url?: string | null;
}

interface LoginCredentials {
    email: string;
    password: string;
    remember?: boolean;
}

interface UpdateProfileData {
    name: string;
    email: string;
    phone?: string;
}

interface ChangePasswordData {
    current_password: string;
    password: string;
    password_confirmation: string;
}

export const useAuth = () => {
    const router = useRouter();
    const user = ref<User | null>(null);
    const loading = ref(false);
    const error = ref<string | null>(null);

    // Check if user is authenticated (check both reactive user and sessionStorage)
    const isAuthenticated = computed(() => {
        if (user.value) return true;

        // Fallback to sessionStorage check
        const userDataStr = sessionStorage.getItem('user');
        if (userDataStr) {
            try {
                user.value = JSON.parse(userDataStr);
                return true;
            } catch {
                sessionStorage.removeItem('user');
                return false;
            }
        }

        return false;
    });

    /**
     * Login user
     */
    const login = async (credentials: LoginCredentials): Promise<boolean> => {
        try {
            loading.value = true;
            error.value = null;

            const response = await axios.post('/api/website/auth/login', credentials);

            user.value = response.data.data.user;

            // Store user in sessionStorage for router guard
            sessionStorage.setItem('user', JSON.stringify(response.data.data.user));

            return true;
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Login failed';
            throw err;
        } finally {
            loading.value = false;
        }
    };

    /**
     * Logout user
     */
    const logout = async (): Promise<void> => {
        try {
            loading.value = true;
            error.value = null;

            await axios.post('/api/website/auth/logout');

            user.value = null;

            // Remove user from sessionStorage
            sessionStorage.removeItem('user');

            // Redirect to home with page reload (Arabic by default)
            window.location.href = '/ar';
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Logout failed';
            console.error('Logout error:', err);
        } finally {
            loading.value = false;
        }
    };

    /**
     * Get current authenticated user
     */
    const fetchUser = async (): Promise<void> => {
        try {
            loading.value = true;
            error.value = null;

            const response = await axios.get('/api/website/auth/me');

            user.value = response.data.data.user;

            // Store user in sessionStorage
            sessionStorage.setItem('user', JSON.stringify(response.data.data.user));
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to fetch user';
            user.value = null;

            // Remove user from sessionStorage if fetch fails
            sessionStorage.removeItem('user');
        } finally {
            loading.value = false;
        }
    };

    /**
     * Update user profile
     */
    const updateProfile = async (data: UpdateProfileData): Promise<boolean> => {
        try {
            loading.value = true;
            error.value = null;

            const response = await axios.put('/api/website/auth/profile', data);

            user.value = response.data.data.user;

            return true;
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Profile update failed';
            throw err;
        } finally {
            loading.value = false;
        }
    };

    /**
     * Change user password
     */
    const changePassword = async (data: ChangePasswordData): Promise<boolean> => {
        try {
            loading.value = true;
            error.value = null;

            await axios.post('/api/website/auth/change-password', data);

            return true;
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Password change failed';
            throw err;
        } finally {
            loading.value = false;
        }
    };

    /**
     * Clear error
     */
    const clearError = () => {
        error.value = null;
    };

    return {
        // State
        user,
        loading,
        error,
        isAuthenticated,
        // Methods
        login,
        logout,
        fetchUser,
        updateProfile,
        changePassword,
        clearError,
    };
};



