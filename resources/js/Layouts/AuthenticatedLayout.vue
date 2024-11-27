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

    <div class="bg-pattern flex max-h-svh min-h-svh">
        <div class="min-h-full">
            <TheSidebar />
        </div>
        <div class="flex-1 overflow-y-scroll text-white">
            <slot />
        </div>
    </div>
</template>

<style scoped>
.bg-pattern {
    background: linear-gradient(
            135deg,
            #0000 18.75%,
            #18181b 0 31.25%,
            #0000 0
        ),
        repeating-linear-gradient(45deg, #18181b -6.25% 6.25%, #1d1d20 0 18.75%);
    background-size: 80px 80px;
}
</style>
