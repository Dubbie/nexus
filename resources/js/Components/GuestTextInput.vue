<script setup>
import { computed, onMounted, ref } from 'vue';

const { label, id } = defineProps({
    label: {
        type: String,
        required: true,
    },
    id: String,
    type: {
        type: String,
        default: 'text',
    },
});

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);
const inputId = id ?? `input-${Math.random().toString(36).substring(2, 9)}`;
const isFocused = ref(false);

const emit = defineEmits(['focus', 'blur', 'input', 'keyup']);

const labelMoved = computed(() => {
    return model.value.length > 0 || isFocused.value;
});

const labelClasses = computed(() => {
    if (labelMoved.value) {
        return 'scale-75 origin-top-left top-1 left-2';
    }

    return 'top-4 left-4';
});

const handleFocus = () => {
    isFocused.value = true;

    emit('focus');
};

const handleBlur = () => {
    isFocused.value = false;

    emit('blur');
};

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <div class="relative">
        <label
            :for="inputId"
            class="absolute block font-bold uppercase tracking-wider text-zinc-600 transition-all md:text-xs"
            :class="labelClasses"
            >{{ label }}</label
        >

        <input
            :id="inputId"
            class="w-full rounded-sm border-none bg-zinc-100 px-2 pb-4 pt-8 font-bold ring-2 ring-transparent transition-all hover:bg-zinc-200/60 hover:ring-zinc-200/70 focus:bg-white focus:ring-2 focus:ring-black md:pb-1 md:pt-5"
            v-model="model"
            :type="type"
            ref="input"
            v-bind="$attrs"
            @focus="handleFocus"
            @blur="handleBlur"
            @input="$emit('input', $event.target.value)"
            @keyup="$emit('keyup', $event)"
        />
    </div>
</template>
