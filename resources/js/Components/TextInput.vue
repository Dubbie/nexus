<script setup>
import { onMounted, ref } from 'vue';

const { dark } = defineProps({
    dark: {
        type: Boolean,
        default: false,
    },
});

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        class="rounded-sm border-transparent font-semibold shadow-sm ring-2 focus:border-transparent focus:ring-2"
        :class="{
            'bg-white/10 text-white ring-transparent backdrop-blur-lg hover:ring-white/20 focus:ring-white':
                dark,
            'border-gray-300 bg-white text-black ring-transparent focus:ring-black':
                !dark,
        }"
        v-model="model"
        ref="input"
    />
</template>
