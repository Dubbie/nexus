<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
    icon: {
        type: Function,
        required: true,
    },
});
</script>

<template>
    <Link
        :href="href"
        class="flex gap-x-2 rounded-lg px-3 py-2 text-sm font-semibold"
        :class="{
            'bg-black/5 text-zinc-700': active,
            'text-zinc-500 hover:text-zinc-600': !active,
        }"
    >
        <component :is="icon" size="20" />
        <span><slot /></span>
    </Link>
</template>
