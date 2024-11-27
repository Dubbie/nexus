<script setup>
import DashboardActivity from '@/Components/DashboardActivity.vue';
import DashboardStatistics from '@/Components/DashboardStatistics.vue';
import TheButton from '@/Components/TheButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="mx-auto w-full max-w-5xl py-12">
            <h1 class="mb-6 text-3xl font-bold">Dashboard</h1>

            <div class="grid grid-cols-3 gap-x-6">
                <div class="col-span-2">
                    <div class="bg-white p-4 text-black sm:p-6">
                        <DashboardStatistics />
                    </div>

                    <div class="mt-6 bg-white px-6 pb-6 pt-4">
                        <p class="mb-3 text-sm font-semibold text-zinc-500">
                            Quicklinks
                        </p>

                        <div class="flex gap-x-1">
                            <TheButton
                                size="sm"
                                color="indigo"
                                :href="route('clients.index')"
                                >Clients</TheButton
                            >
                            <TheButton
                                size="sm"
                                color="indigo"
                                :href="route('insurers.index')"
                                >Insurers</TheButton
                            >
                        </div>
                    </div>
                </div>
                <div>
                    <div class="bg-white p-4 text-black sm:p-6">
                        <p class="font-bold">Activity</p>

                        <DashboardActivity />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
