<script setup>
import TheSidebar from '@/Components/TheSidebar.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const { title } = defineProps({
    title: String,
});

const fullTitle = computed(() => {
    const appName = usePage().props.app.name;

    if (title) {
        return `${title} - ${appName}`;
    }

    return appName;
});
</script>

<template>
    <Head :title="fullTitle" />

    <div class="flex max-h-svh min-h-svh bg-white subpixel-antialiased">
        <div class="min-h-full">
            <TheSidebar />
        </div>
        <div class="flex-1 overflow-y-scroll">
            <slot />
        </div>
    </div>
</template>
