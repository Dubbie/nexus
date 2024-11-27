<script setup>
import GuestTextInput from '@/Components/GuestTextInput.vue';
import TheButton from '@/Components/TheButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import useClients from '@/composables/useClients';
import { useForm } from '@inertiajs/vue3';
import { onMounted } from 'vue';

const { clients, loading, getClients, submitClient, deleteClient } =
    useClients();

const form = useForm({
    name: '',
    redirect: '',
});

const submit = async () => {
    await submitClient(form.name, form.redirect);
};

onMounted(() => {
    getClients();
});
</script>

<template>
    <AuthenticatedLayout>
        <div class="mx-auto w-full max-w-5xl py-12">
            <h1 class="mb-4 text-3xl font-bold">Clients</h1>

            <div class="mb-6">
                <form @submit.prevent="submit">
                    <div class="space-y-3">
                        <div>
                            <GuestTextInput
                                label="Name"
                                id="name"
                                type="text"
                                v-model="form.name"
                                required
                                dark
                            />
                        </div>

                        <div>
                            <GuestTextInput
                                label="Redirect URL"
                                id="redirect"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.redirect"
                                required
                                dark
                            />
                        </div>
                    </div>

                    <div class="mt-3">
                        <TheButton color="indigo" :disabled="form.processing">
                            Add Client
                        </TheButton>
                    </div>
                </form>
            </div>

            <div v-if="loading">
                <p>Loading clients...</p>
            </div>

            <div v-else>
                <div v-if="clients.length > 0">
                    <div v-for="client in clients" :key="client">
                        <div class="bg-zinc-800 p-4">
                            <div class="mb-3 flex justify-between">
                                <p class="text-2xl font-semibold">
                                    {{ client.name }}
                                </p>

                                <div
                                    class="cursor-pointer rounded-xl p-1.5 hover:bg-white/5"
                                    @click="deleteClient(client.id)"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="size-6"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M6 18 18 6M6 6l12 12"
                                        />
                                    </svg>
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-x-6">
                                <p>ID:</p>
                                <p class="col-span-2 font-semibold">
                                    {{ client.id }}
                                </p>
                                <p>Secret</p>
                                <p class="col-span-2 font-semibold">
                                    {{ client.secret }}
                                </p>
                                <p>Redirect</p>
                                <p class="col-span-2 font-semibold">
                                    {{ client.redirect }}
                                </p>
                                <p>Revoked</p>
                                <p class="col-span-2 font-semibold">
                                    {{ client.revoked ? 'Yes' : 'No' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <p>No clients.</p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
