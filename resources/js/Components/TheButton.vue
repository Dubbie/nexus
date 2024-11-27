<script setup>
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    color: {
        type: String,
        default: 'dark',
    },
    plain: {
        type: Boolean,
        default: false,
    },
    outline: {
        type: Boolean,
        default: false,
    },
    type: {
        type: String,
        default: 'button',
    },
    href: {
        type: String,
        default: null,
    },
    size: {
        type: String,
        default: 'md',
    },
    disabled: {
        type: Boolean,
        default: false,
    },
    square: {
        type: Boolean,
        default: false,
    },
    align: {
        type: String,
        default: 'center',
    },
});

const colorClasses = computed(() => {
    if (props.plain) {
        return {
            dark: 'bg-transparent text-black hover:bg-zinc-500/10',
            white: 'bg-transparent text-white hover:bg-white/10',
            zinc: 'bg-transparent text-zinc-500 hover:bg-zinc-500/10 hover:text-zinc-700',
        }[props.color];
    }

    if (props.outline) {
        return {
            dark: 'bg-transparent text-zinc-950 shadow-[inset_0_0_0_1px_rgba(0,0,0,0.15)] hover:bg-zinc-300/10',
            red: 'bg-transparent text-red-500 shadow-[inset_0_0_0_1px_rgba(160,50,50,0.9)] hover:bg-red-500/10',
            white: 'bg-transparent text-white shadow-[inset_0_0_0_1px_rgba(255,255,255,0.15)] hover:bg-white/10',
        }[props.color];
    }

    return {
        zinc: 'bg-zinc-300/35 text-white border-transparent hover:bg-zinc-300/45',
        red: 'bg-red-600 text-white hover:bg-red-700',
        green: 'bg-green-500 text-white hover:bg-green-400 ',
        blue: 'bg-blue-600 text-white hover:bg-blue-500 ',
        indigo: 'bg-indigo-600 text-white hover:bg-indigo-500',
        white: 'bg-white text-zinc-900 hover:bg-white/95',
        dark: 'bg-zinc-800 text-white hover:bg-zinc-700',
    }[props.color];
});

const sizeClasses = computed(() => {
    if (props.square) {
        return {
            xs: 'p-1 text-xs',
            sm: 'p-1.5 text-xs',
            md: 'p-2 text-sm',
            lg: 'px-4 py-2.5 text-sm',
        }[props.size];
    }

    return {
        xs: 'px-2 py-1 text-xs',
        sm: 'px-4 py-2 text-sm',
        md: 'px-6 py-3',
        lg: 'px-4 py-2 text-sm',
    }[props.size];
});

const disabledClasses = computed(() => {
    return props.disabled ? 'opacity-50 pointer-events-none' : '';
});

const alignmentClasses = computed(() => {
    return {
        start: 'justify-start',
        center: 'justify-center',
        end: 'justify-end',
    }[props.align];
});

const squareClasses = computed(() => {
    return props.square ? 'aspect-square' : '';
});
</script>

<template>
    <component
        :is="href ? Link : 'button'"
        :href="href"
        class="relative flex items-center space-x-2 font-medium font-semibold"
        :class="[
            colorClasses,
            sizeClasses,
            disabledClasses,
            squareClasses,
            alignmentClasses,
        ]"
        :type="href ? null : type"
    >
        <slot />
    </component>
</template>
