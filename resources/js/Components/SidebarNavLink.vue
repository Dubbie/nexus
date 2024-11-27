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
        class="block px-3 py-2 font-semibold"
        :class="{
            'text-white': active,
            'text-white/40 hover:text-white/80': !active,
        }"
    >
        <slot />
    </Link>
</template>
