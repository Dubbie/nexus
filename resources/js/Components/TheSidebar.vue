<script setup>
import { usePermissions } from '@/composables/usePermissions';
import SidebarNavLink from './SidebarNavLink.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import Dropdown from './Dropdown.vue';
import DropdownLink from './DropdownLink.vue';

const { hasPermission } = usePermissions(usePage().props.auth.user);

const logout = () => {
    const form = useForm({});

    form.post(route('logout'));
};
</script>

<template>
    <div class="h-full w-64 bg-zinc-950 text-white">
        <div class="flex h-full flex-col gap-y-6 px-3">
            <div class="flex items-center justify-center gap-x-4 pt-6">
                <div>
                    <p class="text-center font-bold tracking-tight text-white">
                        <span class="block leading-none">Sunday</span>
                        <span class="block text-3xl/none">Nexus</span>
                    </p>
                </div>
            </div>

            <div class="grow">
                <SidebarNavLink
                    :href="route('dashboard')"
                    :active="route().current('dashboard')"
                >
                    Dashboard
                </SidebarNavLink>

                <SidebarNavLink
                    v-if="hasPermission('view clients')"
                    :href="route('client.index')"
                    :active="route().current('client.*')"
                >
                    Clients
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
                                <p class="text-sm font-semibold">
                                    {{ $page.props.auth.user.name }}
                                </p>
                                <p class="text-xs text-white/50">
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
