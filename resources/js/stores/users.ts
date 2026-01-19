// resources/js/stores/todos.js
import {defineStore} from 'pinia';

export const useUserStore = defineStore('users', {
    state: () => ({
        users: [],
        user: null,
        statistics: null,
        activeWeek: null,
        team: {},
        weeks: null,
        meta: {
            total: 0,
            to: 1,
            next_page_url: null,
        },
        loading: false,
    }),
    getters: {
        // users: (state): any => state.users
    },
    actions: {
        async fetchUsers(queryParams: object) {
            try {
                this.loading = true;
                const response = await axios.get('/users/list', {params: queryParams});
                this.users = response.data.data || [];
                this.meta = {
                    next_page_url: null,
                    to: response.data.pagination.meta.page.to || 1,
                    total: response.data.pagination.meta.page.total || 0,
                };
            } catch (error) {
                console.log('errr')
            } finally {
                this.loading = false;
            }
        },
        async fetchUser(id: any) {
            try {
                this.loading = true;
                const response = await axios.get(`/users/list/${id}`);

                this.weeks = response.data.data.weeks || [];
                this.statistics = response.data.data?.statistics || {};
                this.user = response.data.data.user || {};
                this.team = response.data.data.team || {};
                // this.users = response.data.data || [];
                // this.meta = {
                //     next_page_url: null,
                //     to: response.data.pagination.meta.page.to || 1,
                //     total: response.data.pagination.meta.page.total || 0,
                // };
            } catch (error) {
                console.log('errr')
            } finally {
                this.loading = false;
            }
        },
        async fetchStatistics(queryParams: object) {
            try {
                this.loading = true;
                const response = await axios.get('/users/statistics', {params: queryParams});

                this.statistics = response.data.data || {};
            } catch (error) {
                console.log('errr')
            } finally {
                this.loading = false;
            }
        },

        async getUserTeamByWeek(queryParams: object) {
            try {
                this.loading = true;
                const response = await axios.get(`/users/list/${queryParams.user_id}/${queryParams.week_id}`);
                this.team = response.data.data.team || {};
            } catch (error) {
                console.log('errr')
            } finally {
                this.loading = false;
            }
        },
    },
});
