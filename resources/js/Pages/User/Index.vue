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
import {
    IconDotsVertical,
    IconEdit,
    IconFilter,
    IconPlus,
    IconX,
} from '@tabler/icons-vue';
import DataTable from '@/Components/DataTable.vue';
import Dropdown from '@/Components/Dropdown.vue';
import RoleBadge from '@/Components/RoleBadge.vue';

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

const headers = [
    {
        key: 'name',
        label: 'Name',
    },
    {
        key: 'roles',
        label: 'Roles',
    },
    {
        key: 'formatted_created_at',
        label: 'Created at',
    },
    {
        key: 'actions',
        label: '',
        classes: 'text-right',
    },
];

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
            <div class="mb-6 flex items-start justify-between">
                <div>
                    <h1 class="text-2xl font-semibold">Users</h1>
                    <p class="text-sm text-zinc-500">
                        Manage users and their account permissions here.
                    </p>
                </div>

                <TheButton color="indigo" @click="showingNewUserModal = true">
                    <IconPlus size="16" class="-ml-0.5" stroke-width="3" />
                    <span>New user</span>
                </TheButton>
            </div>

            <div class="mb-6 flex items-center justify-between gap-x-2">
                <TextInput
                    size="sm"
                    placeholder="Search..."
                    v-model="usersStore.filters.query"
                />

                <div>
                    <TheButton outline size="sm">
                        <IconFilter size="16" />
                        <span>Filters</span>
                    </TheButton>
                </div>
            </div>

            <h5 class="font-semibold">
                <span>All users</span>
                <span class="ml-2 font-medium text-zinc-400">{{
                    usersStore.items.length || 0
                }}</span>
            </h5>

            <DataTable
                :items="usersStore.items"
                :headers="headers"
                base-classes="grid grid-cols-4 gap-x-3 items-center"
            >
                <template #name="{ item }">
                    <div>
                        <p class="font-medium">{{ item.name }}</p>
                        <p class="text-xs text-zinc-500">{{ item.email }}</p>
                    </div>
                </template>

                <template #roles="{ item }">
                    <div class="flex gap-x-1">
                        <RoleBadge
                            v-for="role in item.roles.map((role) => role.name)"
                            :key="role"
                            :role="role"
                        />
                    </div>
                </template>

                <template #actions="{ item }">
                    <div class="flex justify-end">
                        <Dropdown align="right">
                            <template #trigger>
                                <TheButton plain square size="sm">
                                    <IconDotsVertical size="20" />
                                </TheButton>
                            </template>

                            <template #content>
                                <div>
                                    <TheButton
                                        plain
                                        size="sm"
                                        class="w-full"
                                        @click="handleEditUser(item)"
                                    >
                                        <IconEdit size="20" />
                                        <span>Edit</span>
                                    </TheButton>
                                    <TheButton
                                        plain
                                        size="sm"
                                        class="w-full"
                                        @click="usersStore.deleteItem(item.id)"
                                    >
                                        <IconX size="20" />
                                        <span>Delete</span>
                                    </TheButton>
                                </div>
                            </template>
                        </Dropdown>
                    </div>
                </template>
            </DataTable>
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
