import { ref } from 'vue';

export default function useStatistics() {
    const statistics = ref([]);
    const loading = ref(true);

    const getStatistics = async () => {
        loading.value = true;

        try {
            const response = await axios.get(route('api.statistics.index'));
            statistics.value = response.data;
        } catch (error) {
            console.log(error);
        } finally {
            loading.value = false;
        }
    };

    return { statistics, loading, getStatistics };
}
