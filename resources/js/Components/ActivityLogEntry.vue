<script setup>
import { computed } from 'vue';

const { entry } = defineProps({
    entry: {
        type: Object,
        required: true,
    },
});

const formattedType = computed(() => {
    switch (entry.target_type) {
        case 'App\\Models\\User':
            return 'User';
        case 'App\\Models\\Insurer':
            return 'Insurer';
        default:
            return entry.target_type;
    }
});
</script>

<template>
    <div>
        <p class="truncate text-sm font-semibold">
            <span class="mr-1 text-indigo-600">{{ formattedType }}</span>
            <span class="mr-1 text-zinc-500">{{ entry.action }}</span>
            <span class="mr-1 text-zinc-500">by</span>
            <span>{{ entry?.user?.name ?? 'System' }}</span>
        </p>
        <p class="text-xs font-medium text-zinc-400">
            {{ entry.formatted_created_at }}
        </p>
    </div>
</template>
