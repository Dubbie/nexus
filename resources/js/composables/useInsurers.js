import { ref } from 'vue';

export default function useInsurers() {
    const insurers = ref([]);
    const error = ref(null);
    const isSubmitting = ref(false);
    const isUpdating = ref(false);
    const isDeleting = ref(false);
    const isLoading = ref(true);

    const getInsurers = async () => {
        isLoading.value = true;
        try {
            const response = await axios.get(route('api.insurers.index'));
            insurers.value = response.data;
        } catch (error) {
            console.log(error);
        } finally {
            isLoading.value = false;
        }
    };

    const submitInsurer = async (name, shortName) => {
        isSubmitting.value = true;
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
            isSubmitting.value = false;
        }
    };

    const deleteInsurer = async (insurerId) => {
        isDeleting.value = true;
        try {
            await axios.delete(route('api.insurers.destroy', insurerId));
            insurers.value = insurers.value.filter(
                (insurer) => insurer.id !== insurerId,
            );
        } catch (error) {
            console.log(error);
        } finally {
            isDeleting.value = false;
        }
    };

    const updateInsurer = async (insurerId, name, shortName) => {
        isUpdating.value = true;
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
            isUpdating.value = false;
        }
    };

    return {
        isSubmitting,
        isUpdating,
        isDeleting,
        isLoading,
        insurers,
        error,
        getInsurers,
        submitInsurer,
        deleteInsurer,
        updateInsurer,
    };
}
