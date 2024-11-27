<script setup>
import TheButton from '@/Components/TheButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import useInsurers from '@/composables/useInsurers';
import { onMounted, ref } from 'vue';
import NewInsurerModal from './Partials/NewInsurerModal.vue';
import { IconEdit, IconX } from '@tabler/icons-vue';
import EditInsurerModal from './Partials/EditInsurerModal.vue';
import TheContainer from '@/Components/TheContainer.vue';

defineProps({
    count: Number,
});

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
    <AuthenticatedLayout title="Insurers">
        <TheContainer>
            <div class="mb-6 flex justify-between">
                <h1 class="text-3xl font-bold">Insurers</h1>

                <div>
                    <TheButton
                        color="indigo"
                        size="sm"
                        @click="showingNewInsurerModal = true"
                        >New insurer</TheButton
                    >
                </div>
            </div>

            <div class="bg-white px-3 py-3 text-black">
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
                        <div>
                            <div v-for="i in count" :key="i" class="p-3">
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

                        <div v-else>
                            <div
                                v-for="insurer in insurers"
                                :key="insurer.short_name"
                                class="group relative flex items-center justify-between p-3 hover:bg-zinc-100"
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
                                    class="pointer-events-none flex gap-x-1 opacity-0 transition-all group-hover:pointer-events-auto group-hover:opacity-100"
                                >
                                    <TheButton
                                        plain
                                        square
                                        :disabled="isDeleting"
                                        @click="deleteInsurer(insurer.id)"
                                    >
                                        <IconX size="20" />
                                    </TheButton>

                                    <TheButton
                                        plain
                                        square
                                        :disabled="isDeleting"
                                        @click="editInsurer(insurer)"
                                    >
                                        <IconEdit size="20" />
                                    </TheButton>
                                </div>

                                <div
                                    class="pointer-events-none absolute inset-y-0 right-0 my-3 w-[4px] rounded-bl-xl rounded-tl-xl bg-zinc-200 group-hover:opacity-0"
                                ></div>
                            </div>
                        </div>
                    </template>
                </transition>
            </div>
        </TheContainer>

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
