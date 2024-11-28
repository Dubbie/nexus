import { defineStore } from 'pinia';
import { watch } from 'vue';

export const createCrudStore = (storeId, resource) => {
    return defineStore(storeId, {
        state: () => ({
            items: [],
            filters: {
                query: '',
            },
            isLoading: true,
            isUpdating: false,
            isDeleting: false,
            isSubmitting: false,
            error: null,
            debounceTimeout: null,
            abortController: null,
        }),

        actions: {
            async fetchAll() {
                if (this.abortController) {
                    this.abortController.abort();
                }

                this.abortController = new AbortController();

                this.isLoading = true;
                this.error = null;
                try {
                    const response = await axios.get(
                        route(`api.${resource}.index`),
                        {
                            params: this.filters,
                            signal: this.abortController.signal,
                        },
                    );
                    this.items = response.data.data; // Adjust based on your API response structure
                } catch (error) {
                    if (error.code === 'ERR_CANCELED') {
                        console.log('Fetch canceled');
                        return;
                    }

                    console.error(error);
                    this.error =
                        error.response?.data?.message ||
                        'Failed to fetch resources.';
                } finally {
                    this.isLoading = false;
                }
            },

            async createItem(payload) {
                this.isSubmitting = true;
                this.error = null;
                try {
                    const response = await axios.post(
                        route(`api.${resource}.store`),
                        payload,
                    );
                    this.items.push(response.data.data); // Add new item to the list
                } catch (error) {
                    console.error(error);
                    this.error =
                        error.response?.data?.message ||
                        'Failed to create resource.';
                } finally {
                    this.isSubmitting = false;
                }
            },

            async updateItem(id, payload) {
                this.isUpdating = true;
                this.error = null;
                try {
                    const response = await axios.put(
                        route(`api.${resource}.update`, { id }),
                        payload,
                    );
                    const index = this.items.findIndex(
                        (item) => item.id === id,
                    );
                    if (index !== -1) this.items[index] = response.data.data; // Update item in the list
                } catch (error) {
                    console.error(error);
                    this.error =
                        error.response?.data?.message ||
                        'Failed to update resource.';
                } finally {
                    this.isUpdating = false;
                }
            },

            async deleteItem(id) {
                this.isDeleting = true;
                this.error = null;
                try {
                    await axios.delete(
                        route(`api.${resource}.destroy`, { id }),
                    );
                    this.items = this.items.filter((item) => item.id !== id); // Remove item from the list
                } catch (error) {
                    console.error(error);
                    this.error =
                        error.response?.data?.message ||
                        'Failed to delete resource.';
                } finally {
                    this.isDeleting = false;
                }
            },

            init() {
                watch(
                    () => this.filters.query,
                    () => {
                        clearTimeout(this.debounceTimeout);

                        this.debounceTimeout = setTimeout(() => {
                            this.fetchAll();
                        }, 300);
                    },
                );
            },

            reset() {
                this.items = [];
                this.isLoading = true;
                this.isUpdating = false;
                this.isDeleting = false;
                this.isSubmitting = false;
                this.error = null;
            },
        },
    });
};
