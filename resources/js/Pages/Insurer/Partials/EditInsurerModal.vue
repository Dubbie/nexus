<script setup>
import ComboTextInput from '@/Components/ComboTextInput.vue';
import Modal from '@/Components/Modal.vue';
import TheButton from '@/Components/TheButton.vue';
import { useInsurersStore } from '@/stores/useInsurersStore';
import { computed, reactive, ref, watch } from 'vue';

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    insurer: Object,
});

const insurersStore = useInsurersStore();

const isUpdating = computed(() => insurersStore.isUpdating);

const insurerId = ref(null);
const form = reactive({
    name: '',
    short_name: '',
});

const submit = async () => {
    try {
        await insurersStore.updateItem(insurerId.value, form);

        // Reset the form and close the modal
        form.value = { name: '', short_name: '' };
        emit('close');
    } catch (err) {
        console.error('Error submitting insurer:', err);
        // Handle submission error (e.g., show a message)
    }
};

const emit = defineEmits(['close']);

watch(
    () => props.insurer,
    () => {
        if (props.insurer) {
            insurerId.value = props.insurer.id;
            form.name = props.insurer.name;
            form.short_name = props.insurer.short_name;
        } else {
            insurerId.value = null;
            form.name = '';
            form.short_name = '';
        }
    },
);
</script>

<template>
    <Modal max-width="md" :show="show" @close="$emit('close')">
        <div class="p-6">
            <h5 class="mb-6 text-xl font-bold">Edit insurer</h5>

            <form @submit.prevent="submit">
                <div class="space-y-3">
                    <div>
                        <ComboTextInput
                            label="Name"
                            id="name"
                            type="text"
                            v-model="form.name"
                            required
                        />
                    </div>

                    <div>
                        <ComboTextInput
                            label="Short name"
                            id="short_name"
                            type="text"
                            v-model="form.short_name"
                            required
                        />
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-x-1">
                    <TheButton size="sm" plain @click="$emit('close')"
                        >Cancel</TheButton
                    >
                    <TheButton
                        type="submit"
                        size="sm"
                        color="indigo"
                        :disabled="isUpdating"
                        >Update insurer</TheButton
                    >
                </div>
            </form>
        </div>
    </Modal>
</template>
