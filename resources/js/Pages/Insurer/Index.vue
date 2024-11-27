<script setup>
import TheButton from '@/Components/TheButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import useInsurers from '@/composables/useInsurers';
import { onMounted, ref } from 'vue';
import NewInsurerModal from './Partials/NewInsurerModal.vue';
import { IconPencil, IconX } from '@tabler/icons-vue';
import EditInsurerModal from './Partials/EditInsurerModal.vue';

const {
    isDeleting,
    isSubmitting,
    isUpdating,
    isLoading,
    insurers,
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

            <div class="bg-white p-6 text-black">
                <transition
                    enter-active-class="transition ease-out duration-200"
                    enter-from-class="opacity-0"
                    enter-to-class="opacity-100"
                    leave-active-class="transition ease-in duration-150"
                    leave-from-class="opacity-100"
                    leave-to-class="opacity-0"
                    mode="out-in"
                >
                    <template v-if="isLoading">
                        <div class="space-y-3">
                            <div v-for="i in 10" :key="i">
                                <div
                                    class="mb-1 h-5 w-96 animate-pulse bg-zinc-400"
                                ></div>
                                <div
                                    class="h-4 w-40 animate-pulse bg-zinc-300"
                                ></div>
                            </div>
                        </div>
                    </template>

                    <template v-else>
                        <div v-if="insurers.length === 0">
                            <p>No insurers saved.</p>
                        </div>

                        <div v-else class="space-y-3">
                            <div
                                v-for="insurer in insurers"
                                :key="insurer.short_name"
                                class="group flex items-start justify-between"
                            >
                                <div>
                                    <p class="font-bold">{{ insurer.name }}</p>
                                    <p
                                        class="text-xs font-semibold text-zinc-400"
                                    >
                                        {{ insurer.short_name }}
                                    </p>
                                </div>

                                <div
                                    class="pointer-events-none flex gap-x-1 opacity-0 group-hover:pointer-events-auto group-hover:opacity-100"
                                >
                                    <TheButton
                                        plain
                                        square
                                        :disabled="isDeleting"
                                        @click="editInsurer(insurer)"
                                    >
                                        <IconPencil size="20" />
                                    </TheButton>
                                    <TheButton
                                        plain
                                        square
                                        :disabled="isDeleting"
                                        @click="deleteInsurer(insurer.id)"
                                    >
                                        <IconX size="20" />
                                    </TheButton>
                                </div>
                            </div>
                        </div>
                    </template>
                </transition>
            </div>
        </div>

        <NewInsurerModal
            :show="showingNewInsurerModal"
            @close="showingNewInsurerModal = false"
            :loading="isSubmitting"
            :submit-insurer="submitInsurer"
        />

        <EditInsurerModal
            :show="showingEditInsurerModal"
            @close="closeEditInsurerModal"
            :insurer="selectedInsurer"
            :loading="isUpdating"
            :update-insurer="updateInsurer"
        />
    </AuthenticatedLayout>
</template>
