import { createCrudStore } from './baseCrudStore';

export const useUsersStore = createCrudStore('users', 'users');
