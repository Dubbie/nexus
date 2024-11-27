import { defineStore } from 'pinia';

export const useUsersStore = defineStore('users', {
    state: () => ({
        users: [],
        isLoading: true,
        isUpdating: false,
        isDeleting: false,
        isSubmitting: false,
        error: null,
    }),

    actions: {
        async fetchUsers() {
            this.isLoading = true;
            try {
                const response = await axios.get(route('api.users.index'));
                this.users = response.data;
            } catch (error) {
                console.log(error);
            } finally {
                this.isLoading = false;
            }
        },
    },
});
