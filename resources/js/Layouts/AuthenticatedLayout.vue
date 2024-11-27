<script setup>
import TheSidebar from '@/Components/TheSidebar.vue';
</script>

<template>
    <div class="flex min-h-svh bg-zinc-900">
        <div class="min-h-full">
            <TheSidebar />
        </div>
        <div class="flex-1 text-white">
            <slot />
        </div>
    </div>
</template>
