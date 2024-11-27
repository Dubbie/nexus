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
        <div class="flex gap-x-1 text-sm font-semibold">
            <p class="text-indigo-600">{{ formattedType }}</p>
            <p class="text-zinc-500">{{ entry.action }}</p>
            <p class="text-zinc-500">by</p>
            <p>{{ entry?.user?.name ?? 'System' }}</p>
        </div>
        <p class="text-xs font-medium text-zinc-400">
            {{ entry.formatted_created_at }}
        </p>
    </div>
</template>
