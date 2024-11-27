<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import GuestTextInput from '@/Components/GuestTextInput.vue';
import { computed } from 'vue';
import IconButton from '@/Components/IconButton.vue';
import { IconArrowRight } from '@tabler/icons-vue';
import GuestCheckbox from '@/Components/GuestCheckbox.vue';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};

const formValid = computed(() => {
    return form.email.length > 0 && form.password.length > 0;
});
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <h5 class="mb-6 pt-12 text-center text-2xl font-bold">Sign in</h5>

        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <GuestTextInput
                    label="Email"
                    id="email"
                    type="email"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <GuestTextInput
                    label="Password"
                    id="password"
                    type="password"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4 block">
                <label class="flex items-center">
                    <GuestCheckbox
                        name="remember"
                        v-model:checked="form.remember"
                    />
                    <span
                        class="ms-2 select-none text-sm font-medium text-zinc-900"
                        >Remember me</span
                    >
                </label>
            </div>

            <div class="mt-12 flex flex-col items-center">
                <IconButton
                    :icon="IconArrowRight"
                    :disabled="!formValid || form.processing"
                    size="lg"
                    class="mb-6"
                />

                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="text-sm font-semibold uppercase text-zinc-600 hover:text-zinc-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 md:text-xs"
                >
                    Can't sign in?
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>
