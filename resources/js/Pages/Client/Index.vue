<script setup>
import TheButton from '@/Components/TheButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import useClients from '@/composables/useClients';
import { useForm } from '@inertiajs/vue3';
import { computed, onMounted, ref } from 'vue';
import ClientForm from './Partials/ClientForm.vue';

const { clients, loading, getClients, submitClient, deleteClient } =
    useClients();

const form = useForm({
    name: '',
    redirect: '',
});

const showingNewClientEditor = ref(false);

const newClientButtonLabel = computed(() => {
    return showingNewClientEditor.value ? 'Cancel' : 'New Client';
});

const newClientButtonColor = computed(() => {
    return showingNewClientEditor.value ? 'dark' : 'indigo';
});

const toggleNewClientEditor = () => {
    showingNewClientEditor.value = !showingNewClientEditor.value;

    if (!showingNewClientEditor.value) {
        form.reset();
    }
};

const handleClientSubmission = async () => {
    try {
        await submitClient(form.name, form.redirect);
        toggleNewClientEditor();
    } catch (error) {
        console.error('Submission failed:', error);
    }
};

onMounted(() => {
    getClients();
});
</script>

<template>
    <AuthenticatedLayout>
        <div class="mx-auto w-full max-w-5xl py-12">
            <div class="mb-6 flex justify-between">
                <h1 class="text-3xl font-bold">Clients</h1>

                <div>
                    <TheButton
                        size="sm"
                        :color="newClientButtonColor"
                        @click="toggleNewClientEditor"
                    >
                        {{ newClientButtonLabel }}
                    </TheButton>
                </div>
            </div>

            <ClientForm
                v-show="showingNewClientEditor"
                class="my-6"
                v-model="form"
                :submit-client="handleClientSubmission"
            />

            <div>
                <div class="bg-white p-6 text-black">
                    <div v-if="loading">
                        <p>Loading clients...</p>
                    </div>

                    <div v-else>
                        <div v-if="clients.length > 0" class="space-y-4">
                            <div v-for="client in clients" :key="client">
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
                        <div v-else>
                            <p class="font-bold text-zinc-500">No clients.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
