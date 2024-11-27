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
const inputId = id ?? `input-${Math.random().toString(36).substring(2, 9)}`;
const isFocused = ref(false);

const emit = defineEmits(['focus', 'blur', 'input', 'keyup']);

const labelMoved = computed(() => {
    return model.value.length > 0 || isFocused.value;
});

const labelClasses = computed(() => {
    if (labelMoved.value) {
        return 'scale-75 origin-left top-1 left-2';
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
            class="absolute block font-bold uppercase tracking-wider transition-all md:text-xs"
            :class="[
                labelClasses,
                {
                    'text-zinc-600': !dark,
                    'text-zinc-500': dark,
                },
            ]"
            >{{ label }}</label
        >

        <input
            :id="inputId"
            class="w-full rounded-sm border-none px-2 pb-4 pt-8 font-bold ring-2 ring-transparent transition-all focus:ring-2 md:pb-1 md:pt-5"
            :class="{
                'bg-zinc-100 hover:bg-zinc-200/60 hover:ring-zinc-200/70 focus:bg-white focus:ring-black':
                    !dark,
                'bg-white/5 hover:bg-white/10 hover:ring-white/20 focus:bg-transparent focus:ring-white':
                    dark,
            }"
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
