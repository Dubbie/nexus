<script setup>
defineProps({
    items: Array,
    headers: {
        type: Array,
        required: true,
    },
    baseClasses: {
        type: String,
        default: 'grid grid-cols-12 gap-x-3 items-center',
    },
});
</script>

<template>
    <div>
        <div class="border-b border-b-zinc-200" :class="[baseClasses]">
            <div
                v-for="header in headers"
                :key="header.key"
                :class="header.classes"
                class="px-4 py-2 text-sm text-zinc-500 first-of-type:pl-0.5 last-of-type:pr-0.5"
            >
                {{ header.label }}
            </div>
        </div>

        <div class="divide-y divide-zinc-200">
            <div v-for="item in items" :key="item" :class="baseClasses">
                <div
                    v-for="header in headers"
                    :key="header.key"
                    :class="header.classes"
                    class="px-4 py-3 text-sm first-of-type:pl-0.5 last-of-type:pr-0.5"
                >
                    <slot :name="header.key" :item="item">
                        {{ item[header.key] ?? header.key }}
                    </slot>
                </div>
            </div>
        </div>
    </div>
</template>
