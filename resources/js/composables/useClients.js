import { ref } from 'vue';

export default function useClients() {
    const clients = ref([]);
    const loading = ref(false);

    const getClients = async () => {
        loading.value = true;
        try {
            const response = await axios.get('/oauth/clients');

            clients.value = response.data;
        } catch (error) {
            console.log(error);
        } finally {
            loading.value = false;
        }
    };

    const submitClient = async (name, redirect) => {
        loading.value = true;
        try {
            const response = await axios.post('/oauth/clients', {
                name,
                redirect,
            });
            const newClient = response.data;

            // Check if client already exists and update, else add new client
            const existingClientIndex = clients.value.findIndex(
                (client) => client.id === newClient.id,
            );
            if (existingClientIndex !== -1) {
                clients.value[existingClientIndex] = newClient; // Update existing client
            } else {
                clients.value.push(newClient); // Add new client
            }
        } catch (error) {
            console.log(error);
        } finally {
            loading.value = false;
        }
    };

    const deleteClient = async (clientId) => {
        loading.value = true;
        try {
            await axios.delete(`/oauth/clients/${clientId}`);
            clients.value = clients.value.filter(
                (client) => client.id !== clientId,
            );
        } catch (error) {
            console.log(error);
        } finally {
            loading.value = false;
        }
    };

    return {
        getClients,
        submitClient,
        deleteClient,
        clients,
        loading,
    };
}
