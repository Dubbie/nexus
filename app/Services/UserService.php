<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserService
{
    /**
     * Create a new user with the given data
     *
     * @param array $data The user data including optional roles
     * @return User The newly created user with relations loaded
     */
    public function createUser(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $user = User::create($data);
            $this->syncUserRoles($user, $data);
            return $this->loadUserRelations($user);
        });
    }

    /**
     * Update an existing user with the given data
     * 
     * @param int $id The ID of the user to update
     * @param array $data The updated user data including optional roles
     * @return User The updated user with relations loaded
     */
    public function updateUser(int $id, array $data): User
    {
        return DB::transaction(function () use ($id, $data) {
            $user = $this->findUser($id);
            $this->updateUserData($user, $data);
            $this->syncUserRoles($user, $data);
            return $this->loadUserRelations($user);
        });
    }

    /**
     * Find a user by ID or fail
     */
    private function findUser(int $id): User 
    {
        return User::findOrFail($id);
    }

    /**
     * Update the user's data
     */
    private function updateUserData(User $user, array $data): void
    {
        $user->update($data);
    }

    /**
     * Sync user roles if provided
     */
    private function syncUserRoles(User $user, array $data): void
    {
        if (isset($data['roles']) && !empty($data['roles'])) {
            $user->syncRoles($data['roles']);
        }
    }

    /**
     * Load user relations and return user
     */
    private function loadUserRelations(User $user): User
    {
        $user->load('roles');
        return $user;
    }
}
