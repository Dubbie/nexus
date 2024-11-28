<script setup>
import ComboTextInput from '@/Components/ComboTextInput.vue';
import Modal from '@/Components/Modal.vue';
import TheButton from '@/Components/TheButton.vue';
import TheCheckbox from '@/Components/TheCheckbox.vue';
import { useRolesStore } from '@/stores/useRolesStore';
import { useUsersStore } from '@/stores/useUsersStore';
import { computed, onMounted, reactive, ref, watch } from 'vue';

const usersStore = useUsersStore();
const rolesStore = useRolesStore();
const roles = computed(() => rolesStore.items);
const rolesLoading = computed(() => rolesStore.isLoading);

const userUpdating = computed(() => usersStore.isUpdating);
const userError = computed(() => usersStore.error);

const { show, user } = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    user: Object,
});

const userId = ref(null);
const form = reactive({
    name: '',
    email: '',
    roles: [],
});

const submit = async () => {
    await usersStore.updateItem(userId.value, form);

    if (!userError.value) {
        closeModal();
    }
};

const closeModal = () => {
    form.name = '';
    form.email = '';
    form.roles = [];
    emit('close');
};

const emit = defineEmits(['close']);

watch(
    () => user,
    () => {
        if (user) {
            userId.value = user.id;
            form.name = user.name;
            form.email = user.email;
            form.roles = user.roles.map((role) => role.name);
        } else {
            userId.value = null;
            form.name = '';
            form.email = '';
            form.roles = [];
        }
    },
);

onMounted(() => {
    rolesStore.fetchAll();
});
</script>

<template>
    <Modal :show="show" max-width="md" @close="emit('close')">
        <div class="p-6">
            <h5 class="mb-6 text-xl font-bold">Edit user</h5>

            <form @submit.prevent="submit" autocomplete="off">
                <div class="space-y-3">
                    <div>
                        <ComboTextInput
                            label="Name"
                            id="name"
                            type="text"
                            v-model="form.name"
                            autocomplete="off"
                            required
                        />
                    </div>

                    <div>
                        <ComboTextInput
                            label="Email"
                            id="email"
                            type="email"
                            v-model="form.email"
                            autocomplete="off"
                            required
                        />
                    </div>
                </div>

                <div class="mt-3">
                    <p class="text-sm font-semibold text-zinc-500">
                        Select the associated roles for this user.
                    </p>

                    <div v-if="!rolesLoading">
                        <div v-for="role in roles" :key="role.id">
                            <TheCheckbox
                                :id="`ch-${role.id}`"
                                :value="role.name"
                                v-model:checked="form.roles"
                            />
                            <label
                                :for="`ch-${role.id}`"
                                class="ml-2 text-sm font-semibold"
                                >{{ role.name }}</label
                            >
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end gap-x-1">
                    <TheButton plain size="sm" @click="$emit('close')"
                        >Cancel</TheButton
                    >
                    <TheButton
                        type="submit"
                        color="indigo"
                        size="sm"
                        :disabled="userUpdating"
                        >Update</TheButton
                    >
                </div>
            </form>
        </div>
    </Modal>
</template>
