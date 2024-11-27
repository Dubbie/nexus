<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
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
                            <InputLabel for="name" value="Name" />
                            <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.name"
                                required
                            />
                        </div>

                        <div>
                            <InputLabel for="redirect" value="Redirect URL" />
                            <TextInput
                                id="redirect"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.redirect"
                                required
                            />
                        </div>
                    </div>

                    <div class="mt-6">
                        <PrimaryButton :disabled="form.processing">
                            Add Client
                        </PrimaryButton>
                    </div>
                </form>
            </div>

            <div v-if="loading">
                <p>Loading clients...</p>
            </div>

            <div v-else>
                <div v-if="clients.length > 0">
                    <div v-for="client in clients" :key="client">
                        <div
                            class="rounded-2xl bg-white p-4 ring-1 ring-zinc-300"
                        >
                            <div class="mb-3 flex justify-between">
                                <p class="text-2xl font-semibold">
                                    {{ client.name }}
                                </p>

                                <div
                                    class="cursor-pointer rounded-xl p-1.5 hover:bg-zinc-200"
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
                            <p>ID: {{ client.id }}</p>
                            <p>Secret: {{ client.secret }}</p>
                            <p>Redirect: {{ client.redirect }}</p>
                            <p>Revoked: {{ client.revoked ? 'Yes' : 'No' }}</p>
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
