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
    usersStore.fetchAll();
});

onUnmounted(() => {
    usersStore.reset();
});
</script>

<template>
    <AuthenticatedLayout title="Users">
        <TheContainer>
            <div class="mb-6 flex justify-between">
                <h1 class="text-3xl font-bold">Users</h1>

                <div>
                    <TheButton
                        color="indigo"
                        size="sm"
                        @click="showingNewUserModal = true"
                        >New user</TheButton
                    >
                </div>
            </div>

            <div class="bg-white p-6 text-black">
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
