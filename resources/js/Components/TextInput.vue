<script setup>
import { computed, onMounted, ref } from 'vue';

const { size } = defineProps({
    size: {
        type: String,
        default: 'md',
    },
});

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

const sizeClasses = computed(() => {
    return {
        sm: 'text-sm rounded-lg h-8 px-3',
        md: 'text-sm rounded-lg h-10 px-4',
    }[size];
});

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        class="border-none shadow shadow-black/5 ring-1 ring-inset ring-zinc-200 hover:ring-zinc-300 focus:ring-2 focus:ring-inset focus:ring-indigo-500"
        :class="[sizeClasses]"
        v-model="model"
        ref="input"
    />
</template>
