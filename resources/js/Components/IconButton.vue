<script setup>
import { computed } from 'vue';

const { color, size, disabled } = defineProps({
    color: {
        type: String,
        default: 'indigo',
    },
    size: {
        type: String,
        default: 'md',
    },
    icon: {
        type: Function,
        required: true,
    },
    disabled: {
        type: Boolean,
        default: false,
    },
});

const colorClasses = computed(() => {
    if (disabled) {
        return 'cursor-not-allowed ring-zinc-200 text-zinc-400';
    }

    const colorMap = {
        indigo: 'ring-transparent bg-indigo-500 text-white hover:bg-indigo-600',
    };

    return colorMap[color] ? colorMap[color] + ' cursor-pointer' : '';
});

const sizeClasses = computed(() => {
    return {
        sm: 'size-5',
        md: 'size-6',
        lg: 'size-8',
        xl: 'size-8',
    }[size];
});

const paddingClasses = computed(() => {
    return {
        sm: 'p-2',
        md: 'p-4 ',
        lg: 'p-7 rounded-3xl md:p-5',
    }[size];
});
</script>

<template>
    <button
        class="flex items-center justify-center ring-2 ring-inset"
        :class="[colorClasses, paddingClasses]"
    >
        <component :is="icon" :class="sizeClasses" />
    </button>
</template>
