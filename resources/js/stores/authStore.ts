import { defineStore } from 'pinia';
import { ref, computed } from 'vue';

export const useAuthStore = defineStore('auth', () => {
    const user = ref((window as any).authUser || null);

    const isAuthenticated = computed(() => !!user.value);

    const setUser = (userData: any) => {
        user.value = userData;
        (window as any).authUser = userData;
    };

    const clearUser = () => {
        user.value = null;
        (window as any).authUser = null;
    };

    return {
        user,
        isAuthenticated,
        setUser,
        clearUser,
    };
});
