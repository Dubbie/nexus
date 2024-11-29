<script setup>
import { computed } from 'vue';

const { role } = defineProps({
    role: {
        type: String,
        required: true,
    },
});

const formattedRole = computed(() => {
    return role.charAt(0).toUpperCase() + role.slice(1);
});

const colorClasses = computed(() => {
    return {
        indigo: 'bg-indigo-100 text-indigo-600',
        gray: 'bg-gray-100 text-gray-600',
    }[role];
});
</script>

<template>
    <div :class="colorClasses">{{ formattedRole }}</div>
</template>
