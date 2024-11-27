<script setup>
import useStatistics from '@/composables/useStatistics';
import { onMounted } from 'vue';

const { statistics, loading, getStatistics } = useStatistics();

const columns = [
    {
        key: 'users',
        label: 'Users',
    },
    {
        key: 'clients',
        label: 'Clients',
    },
    {
        key: 'insurers',
        label: 'Insurers',
    },
];

onMounted(() => {
    getStatistics();
});
</script>

<template>
    <div>
        <div class="grid grid-cols-3 gap-x-6">
            <p
                v-for="column in columns"
                :key="column.key"
                class="text-center text-sm font-semibold text-zinc-500"
            >
                {{ column.label }}
            </p>
        </div>
        <transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition ease-in duration-150"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
            mode="out-in"
        >
            <div v-if="loading" class="grid grid-cols-3 gap-x-6">
                <div
                    v-for="column in columns"
                    :key="column.key"
                    class="text-center"
                >
                    <div class="mt-1 flex justify-center">
                        <div class="h-9 w-24 animate-pulse bg-zinc-300"></div>
                    </div>
                </div>
            </div>
            <div v-else class="grid grid-cols-3 gap-x-6">
                <div
                    v-for="column in columns"
                    :key="column.key"
                    class="text-center"
                >
                    <div class="mt-1 flex justify-center">
                        <p class="text-3xl font-bold">
                            {{ statistics[column.key] }}
                        </p>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>
