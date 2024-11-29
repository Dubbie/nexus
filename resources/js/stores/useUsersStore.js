import { createCrudStore } from './baseCrudStore';

export const useUsersStore = createCrudStore('users', 'user');
