<script setup>
import ComboTextInput from '@/Components/ComboTextInput.vue';
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
                    <ComboTextInput
                        label="Name"
                        id="name"
                        type="text"
                        v-model="form.name"
                        required
                        dark
                    />
                </div>

                <div>
                    <ComboTextInput
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
