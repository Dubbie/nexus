<script setup>
import DashboardActivity from '@/Components/DashboardActivity.vue';
import DashboardStatistics from '@/Components/DashboardStatistics.vue';
import TheButton from '@/Components/TheButton.vue';
import TheContainer from '@/Components/TheContainer.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout title="Dashboard">
        <TheContainer>
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
                            <TheButton
                                size="sm"
                                color="indigo"
                                :href="route('users.index')"
                                >Users</TheButton
                            >
                        </div>
                    </div>
                </div>
                <div>
                    <div class="bg-white p-4 text-black sm:p-6">
                        <p class="mb-4 font-bold">Activity</p>

                        <DashboardActivity />
                    </div>
                </div>
            </div>
        </TheContainer>
    </AuthenticatedLayout>
</template>
