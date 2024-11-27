import { ref } from 'vue';

export default function useActivityLog(count = 5) {
    const activityLog = ref([]);
    const loading = ref(true);

    const getActivityLog = async () => {
        loading.value = true;
        try {
            const response = await axios.get(route('api.activity-log.index'), {
                params: {
                    count: count,
                },
            });
            activityLog.value = response.data;
        } catch (error) {
            console.log(error);
        } finally {
            loading.value = false;
        }
    };

    return { activityLog, loading, getActivityLog };
}
