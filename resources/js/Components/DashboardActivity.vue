<script setup>
import useActivityLog from '@/composables/useActivityLog';
import { onMounted } from 'vue';
import ActivityLogEntry from './ActivityLogEntry.vue';

const { activityLog, loading, getActivityLog } = useActivityLog();

onMounted(() => {
    getActivityLog();
});
</script>

<template>
    <div>
        <div v-if="loading">
            <p>Loading activity...</p>
        </div>
        <div v-else class="space-y-3">
            <ActivityLogEntry
                v-for="entry in activityLog"
                :key="entry.id"
                :entry="entry"
            />
        </div>
    </div>
</template>
