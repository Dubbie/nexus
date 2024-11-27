<script setup>
import TheButton from '@/Components/TheButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import useInsurers from '@/composables/useInsurers';
import { onMounted, ref } from 'vue';
import NewInsurerModal from './Partials/NewInsurerModal.vue';
import { IconPencil, IconX } from '@tabler/icons-vue';
import EditInsurerModal from './Partials/EditInsurerModal.vue';

const {
    insurers,
    loading,
    getInsurers,
    submitInsurer,
    updateInsurer,
    deleteInsurer,
} = useInsurers();

const showingNewInsurerModal = ref(false);
const showingEditInsurerModal = ref(false);
const selectedInsurer = ref(null);

const editInsurer = (insurer) => {
    selectedInsurer.value = insurer;
    showingEditInsurerModal.value = true;
};

const closeEditInsurerModal = () => {
    showingEditInsurerModal.value = false;
    selectedInsurer.value = null;
};

onMounted(() => {
    getInsurers();
});
</script>

<template>
    <AuthenticatedLayout>
        <div class="mx-auto w-full max-w-5xl py-12">
            <div class="mb-6 flex justify-between">
                <h1 class="mb-4 text-3xl font-bold">Insurers</h1>

                <div>
                    <TheButton
                        color="indigo"
                        @click="showingNewInsurerModal = true"
                        >New insurer</TheButton
                    >
                </div>
            </div>

            <div v-if="loading">
                <p>Loading insurers...</p>
            </div>

            <div v-else>
                <div v-if="insurers.length === 0">
                    <p>No insurers saved.</p>
                </div>

                <div v-else class="space-y-3 bg-white p-6 text-black">
                    <div
                        v-for="insurer in insurers"
                        :key="insurer.short_name"
                        class="group flex items-start justify-between"
                    >
                        <div>
                            <p class="font-bold">{{ insurer.name }}</p>
                            <p class="text-xs font-semibold text-zinc-400">
                                {{ insurer.short_name }}
                            </p>
                        </div>

                        <div
                            class="pointer-events-none flex gap-x-1 opacity-0 group-hover:pointer-events-auto group-hover:opacity-100"
                        >
                            <TheButton
                                plain
                                square
                                @click="editInsurer(insurer)"
                            >
                                <IconPencil size="20" />
                            </TheButton>
                            <TheButton
                                plain
                                square
                                @click="deleteInsurer(insurer.id)"
                            >
                                <IconX size="20" />
                            </TheButton>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <NewInsurerModal
            :show="showingNewInsurerModal"
            @close="showingNewInsurerModal = false"
            :submit-insurer="submitInsurer"
        />

        <EditInsurerModal
            :show="showingEditInsurerModal"
            @close="closeEditInsurerModal"
            :insurer="selectedInsurer"
            :update-insurer="updateInsurer"
        />
    </AuthenticatedLayout>
</template>
