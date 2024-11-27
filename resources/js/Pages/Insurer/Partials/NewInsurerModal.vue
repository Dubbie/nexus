<script setup>
import GuestTextInput from '@/Components/GuestTextInput.vue';
import Modal from '@/Components/Modal.vue';
import TheButton from '@/Components/TheButton.vue';
import { reactive, ref } from 'vue';

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    submitInsurer: {
        type: Function,
        default: () => {},
    },
});

const loading = ref(false);
const form = reactive({
    name: '',
    short_name: '',
});

const submit = async () => {
    loading.value = true;

    try {
        await props.submitInsurer(form.name, form.short_name);

        // Reset the form and close the modal
        form.value = { name: '', short_name: '' };
        emit('close');
    } catch (err) {
        console.error('Error submitting insurer:', err);
        // Handle submission error (e.g., show a message)
    } finally {
        loading.value = false;
    }
};

const emit = defineEmits(['close']);
</script>

<template>
    <Modal max-width="md" :show="show" @close="$emit('close')">
        <div class="p-6">
            <h5 class="mb-6 text-xl font-bold">New insurer</h5>

            <form @submit.prevent="submit">
                <div class="space-y-3">
                    <div>
                        <GuestTextInput
                            label="Name"
                            id="name"
                            type="text"
                            v-model="form.name"
                            required
                        />
                    </div>

                    <div>
                        <GuestTextInput
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
                        :disabled="loading"
                        >Save insurer</TheButton
                    >
                </div>
            </form>
        </div>
    </Modal>
</template>
