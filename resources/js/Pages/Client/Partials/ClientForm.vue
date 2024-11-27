<script setup>
import GuestTextInput from '@/Components/GuestTextInput.vue';
import TheButton from '@/Components/TheButton.vue';

const props = defineProps({
    modelValue: Object,
    submitClient: Function,
});

const form = props.modelValue;
</script>

<template>
    <div class="mb-6">
        <form @submit.prevent="submitClient">
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
                <TheButton
                    type="submit"
                    color="indigo"
                    size="sm"
                    :disabled="form.processing"
                >
                    Add Client
                </TheButton>
            </div>
        </form>
    </div>
</template>
