<script setup>
import TheButton from '@/Components/TheButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TheContainer from '@/Components/TheContainer.vue';
import { useUsersStore } from '@/stores/useUsersStore';
import { onMounted } from 'vue';
import UserListHeader from './Partials/UserListHeader.vue';
import UserList from './Partials/UserList.vue';

defineProps({
    count: Number,
});

const usersStore = useUsersStore();

onMounted(() => {
    usersStore.fetchUsers();
});
</script>

<template>
    <AuthenticatedLayout title="Users">
        <TheContainer>
            <div class="mb-6 flex justify-between">
                <h1 class="text-3xl font-bold">Users</h1>

                <div>
                    <TheButton color="indigo" size="sm">New user</TheButton>
                </div>
            </div>

            <div class="bg-white p-6 text-black">
                <UserListHeader />

                <UserList
                    :users="usersStore.users"
                    :loading="usersStore.isLoading"
                />
            </div>
        </TheContainer>
    </AuthenticatedLayout>
</template>
