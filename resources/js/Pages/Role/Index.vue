<script setup>
import TheButton from '@/Components/TheButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TheContainer from '@/Components/TheContainer.vue';
import { useRolesStore } from '@/stores/useRolesStore';
import { computed, onMounted, onUnmounted } from 'vue';

const rolesStore = useRolesStore();
const roles = computed(() => rolesStore.items);

onMounted(() => {
    rolesStore.fetchAll();
});

onUnmounted(() => {
    rolesStore.reset();
});
</script>

<template>
    <AuthenticatedLayout title="Users">
        <TheContainer>
            <div class="mb-6 flex justify-between">
                <h1 class="text-3xl font-bold">Roles</h1>

                <div>
                    <TheButton color="indigo" size="sm">New role</TheButton>
                </div>
            </div>

            <div class="bg-white p-6 text-black">
                <div v-if="roles.length === 0">
                    <p>No roles found.</p>
                </div>

                <div v-else>
                    <div v-for="role in roles" :key="role.id">
                        <p>{{ role.name }}</p>
                    </div>
                </div>
            </div>
        </TheContainer>
    </AuthenticatedLayout>
</template>
