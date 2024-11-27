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
        <transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition ease-in duration-150"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
            mode="out-in"
        >
            <div v-if="loading">
                <p class="text-sm font-semibold text-zinc-500">
                    Loading activity...
                </p>
            </div>
            <div v-else class="space-y-3">
                <ActivityLogEntry
                    v-for="entry in activityLog"
                    :key="entry.id"
                    :entry="entry"
                />
            </div>
        </transition>
    </div>
</template>
