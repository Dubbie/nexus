<script setup>
import TheButton from '@/Components/TheButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TheContainer from '@/Components/TheContainer.vue';
import { useUsersStore } from '@/stores/useUsersStore';
import { onMounted, onUnmounted, ref } from 'vue';
import UserListHeader from './Partials/UserListHeader.vue';
import UserList from './Partials/UserList.vue';
import NewUserModal from './Partials/NewUserModal.vue';
import EditUserModal from './Partials/EditUserModal.vue';
import TextInput from '@/Components/TextInput.vue';
import { IconPlus } from '@tabler/icons-vue';

defineProps({
    count: Number,
});

const usersStore = useUsersStore();

const showingNewUserModal = ref(false);
const showingEditUserModal = ref(false);
const selectedUser = ref(null);

const handleEditUser = (user) => {
    selectedUser.value = user;
    showingEditUserModal.value = true;
};

const closeEditUserModal = () => {
    showingEditUserModal.value = false;
    selectedUser.value = null;
};

onMounted(() => {
    usersStore.init();
    usersStore.fetchAll();
});

onUnmounted(() => {
    usersStore.reset();
});
</script>

<template>
    <AuthenticatedLayout title="Users">
        <TheContainer>
            <div class="mb-6">
                <h1 class="text-3xl font-bold">Users</h1>
                <p class="text-sm font-medium text-zinc-400">
                    Manage users and their account permissions here.
                </p>
            </div>

            <div class="mb-3 flex items-center justify-between">
                <h5 class="text-xl font-semibold">
                    <span>All users</span>
                    <span class="ml-2 text-zinc-400">{{
                        usersStore.items.length || 0
                    }}</span>
                </h5>

                <div class="flex items-center gap-x-3">
                    <TextInput
                        placeholder="Search..."
                        class="text-sm"
                        v-model="usersStore.filters.query"
                        dark
                    />

                    <TheButton
                        color="indigo"
                        size="sm"
                        @click="showingNewUserModal = true"
                    >
                        <IconPlus size="20" />
                        <span>New user</span>
                    </TheButton>
                </div>
            </div>

            <div class="bg-white px-6 py-3 text-black">
                <UserListHeader />

                <UserList
                    :users="usersStore.items"
                    :loading="usersStore.isLoading"
                    @edit-user="handleEditUser"
                />
            </div>
        </TheContainer>

        <NewUserModal
            :show="showingNewUserModal"
            @close="showingNewUserModal = false"
        />

        <EditUserModal
            :show="showingEditUserModal"
            @close="closeEditUserModal"
            :user="selectedUser"
        />
    </AuthenticatedLayout>
</template>
