<script setup>
const classes = 'px-3 py-2 first-of-type:pl-1 last-of-type:pr-1';
</script>

<template>
    <div class="grid grid-cols-6 gap-x-6 text-sm font-semibold text-zinc-500">
        <p class="col-span-2" :class="classes">Name</p>
        <p class="col-span-2 text-center" :class="classes">Roles</p>
        <p class="text-center" :class="classes">Created at</p>
        <p class="text-right" :class="classes">
            <span class="sr-only">Actions</span>
        </p>
    </div>
</template>
