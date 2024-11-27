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
});
</script>

<template>
    <Link
        :href="href"
        class="block px-3 py-2 text-sm font-medium"
        :class="{
            'text-white': active,
            'text-white/50 hover:text-white/70': !active,
        }"
    >
        <slot />
    </Link>
</template>
