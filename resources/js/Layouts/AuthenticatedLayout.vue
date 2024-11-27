<script setup>
import TheSidebar from '@/Components/TheSidebar.vue';
</script>

<template>
    <div class="flex max-h-svh min-h-svh bg-zinc-900">
        <div class="min-h-full">
            <TheSidebar />
        </div>
        <div class="flex-1 overflow-y-scroll text-white">
            <slot />
        </div>
    </div>
</template>
