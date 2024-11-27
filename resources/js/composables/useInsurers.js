import { ref } from 'vue';

export default function useInsurers() {
    const insurers = ref([]);
    const loading = ref(false);
    const error = ref(null);

    const getInsurers = async () => {
        loading.value = true;
        try {
            const response = await axios.get(route('api.insurers.index'));
            insurers.value = response.data;
        } catch (error) {
            console.log(error);
        } finally {
            loading.value = false;
        }
    };

    const submitInsurer = async (name, shortName) => {
        loading.value = true;
        try {
            await axios.post(route('api.insurers.store'), {
                name: name,
                short_name: shortName,
            });
            await getInsurers(); // Refresh the insurers list after successful submission
        } catch (err) {
            console.error(err);
            error.value =
                err.response?.data?.message || 'Error creating insurer.';
        } finally {
            loading.value = false;
        }
    };

    const deleteInsurer = async (insurerId) => {
        loading.value = true;
        try {
            await axios.delete(route('api.insurers.destroy', insurerId));
            insurers.value = insurers.value.filter(
                (insurer) => insurer.id !== insurerId,
            );
        } catch (error) {
            console.log(error);
        } finally {
            loading.value = false;
        }
    };

    const updateInsurer = async (insurerId, name, shortName) => {
        loading.value = true;
        try {
            await axios.put(route('api.insurers.update', insurerId), {
                name: name,
                short_name: shortName,
            });
            await getInsurers(); // Refresh the insurers list after successful update
        } catch (err) {
            console.error(err);
            error.value =
                err.response?.data?.message || 'Error updating insurer.';
        } finally {
            loading.value = false;
        }
    };

    return {
        insurers,
        loading,
        error,
        getInsurers,
        submitInsurer,
        deleteInsurer,
        updateInsurer,
    };
}
