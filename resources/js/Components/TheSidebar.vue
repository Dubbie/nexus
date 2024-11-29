<script setup>
import { usePermissions } from '@/composables/usePermissions';
import SidebarNavLink from './SidebarNavLink.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import Dropdown from './Dropdown.vue';
import DropdownLink from './DropdownLink.vue';
import {
    IconHome,
    IconLock,
    IconShield,
    IconUsers,
    IconWorld,
} from '@tabler/icons-vue';

const { hasPermission } = usePermissions(usePage().props.auth.user);

const logout = () => {
    const form = useForm({});

    form.post(route('logout'));
};
</script>

<template>
    <div class="h-full w-64 border-r border-zinc-200 bg-white">
        <div class="flex h-full flex-col gap-y-6 px-3">
            <div class="px-3 pt-6">
                <p class="font-bold tracking-tight text-black">
                    <span class="mr-1 text-zinc-800">Sunday</span>
                    <span class="text-indigo-600">Nexus</span>
                </p>
            </div>

            <div class="grow">
                <SidebarNavLink
                    :href="route('dashboard')"
                    :active="route().current('dashboard')"
                    :icon="IconHome"
                >
                    Dashboard
                </SidebarNavLink>

                <SidebarNavLink
                    v-if="hasPermission('view users')"
                    :href="route('users.index')"
                    :active="route().current('users.*')"
                    :icon="IconUsers"
                >
                    Users
                </SidebarNavLink>

                <SidebarNavLink
                    v-if="hasPermission('view clients')"
                    :href="route('clients.index')"
                    :active="route().current('clients.*')"
                    :icon="IconWorld"
                >
                    Clients
                </SidebarNavLink>

                <SidebarNavLink
                    v-if="hasPermission('view insurers')"
                    :href="route('insurers.index')"
                    :active="route().current('insurers.*')"
                    :icon="IconShield"
                >
                    Insurers
                </SidebarNavLink>

                <SidebarNavLink
                    v-if="hasPermission('view users')"
                    :href="route('roles.index')"
                    :active="route().current('roles.*')"
                    :icon="IconLock"
                >
                    Roles
                </SidebarNavLink>
            </div>

            <div class="pb-3">
                <Dropdown align="outside-bottom-right">
                    <template #trigger>
                        <div class="flex cursor-pointer items-center gap-x-3">
                            <img
                                src="//picsum.photos/96"
                                alt=""
                                class="size-8 rounded-lg"
                            />

                            <div>
                                <p class="truncate text-sm font-semibold">
                                    {{ $page.props.auth.user.name }}
                                </p>
                                <p class="truncate text-xs text-zinc-500">
                                    {{ $page.props.auth.user.email }}
                                </p>
                            </div>
                        </div>
                    </template>

                    <template #content>
                        <div>
                            <DropdownLink href="#!" @click="logout"
                                >Logout</DropdownLink
                            >
                        </div>
                    </template>
                </Dropdown>
            </div>
        </div>
    </div>
</template>
