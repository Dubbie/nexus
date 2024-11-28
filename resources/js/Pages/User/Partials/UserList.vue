<script setup>
import Dropdown from '@/Components/Dropdown.vue';
import TheButton from '@/Components/TheButton.vue';
import { useUsersStore } from '@/stores/useUsersStore';
import { IconDotsVertical, IconEdit, IconX } from '@tabler/icons-vue';

const usersStore = useUsersStore();

const { users } = defineProps({
    users: {
        type: Array,
        default: () => [],
    },
    loading: {
        type: Boolean,
        default: true,
    },
});

const formattedRoles = (user) => {
    if (!user.roles) return 'No roles';

    return user.roles.map((role) => formatSpecificRole(role.name)).join(', ');
};

const formatSpecificRole = (role) => {
    // Uppercase first
    return role.charAt(0).toUpperCase() + role.slice(1);
};

const deleteUser = (user) => {
    if (confirm('Are you sure you want to delete this user?')) {
        usersStore.deleteItem(user.id);
    }
};

defineEmits(['edit-user']);
</script>

<template>
    <div>
        <transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition ease-in duration-150"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
            mode="out-in"
        >
            <div v-if="loading">
                <p class="py-4 text-sm font-semibold text-zinc-500">
                    Loading users...
                </p>
            </div>
            <div v-else-if="users.length === 0">
                <p class="py-4 text-sm font-semibold text-zinc-500">
                    No users saved.
                </p>
            </div>
            <div v-else class="text-sm font-semibold">
                <div
                    v-for="user in users"
                    :key="user.id"
                    class="grid grid-cols-6 items-center gap-x-6 border-b py-2 first-of-type:border-t last-of-type:border-b-0"
                >
                    <div class="col-span-2 py-2 pl-1 pr-3">
                        <p>{{ user.name }}</p>
                        <p class="text-xs text-zinc-500">{{ user.email }}</p>
                    </div>

                    <div class="col-span-2 px-3 py-2 text-center">
                        <p>{{ formattedRoles(user) }}</p>
                    </div>

                    <div class="px-3 py-2 text-center">
                        <p>{{ user.formatted_created_at }}</p>
                    </div>

                    <div class="flex justify-end py-2 pl-3 pr-1">
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
                                        @click="$emit('edit-user', user)"
                                    >
                                        <IconEdit size="20" />
                                        <span>Edit</span>
                                    </TheButton>
                                    <TheButton
                                        plain
                                        size="sm"
                                        class="w-full"
                                        @click="deleteUser(user)"
                                    >
                                        <IconX size="20" />
                                        <span>Delete</span>
                                    </TheButton>
                                </div>
                            </template>
                        </Dropdown>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>
