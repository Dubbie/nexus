export function usePermissions(user) {
    // If no user is logged in, return false for all permission checks
    if (!user) {
        return {
            hasPermission: () => false,
        };
    }

    // Check if the user has a specific permission directly or through roles
    const hasPermission = (permission) => {
        // First check in the user's direct permissions
        if (user.permissions && user.permissions.includes(permission)) {
            return true;
        }

        // Then check in the roles for any permissions the user might have through their roles
        if (user.roles && user.roles.length > 0) {
            // Iterate through the roles to check if the role contains the permission
            for (const role of user.roles) {
                if (
                    role.permissions &&
                    role.permissions.map((p) => p.name).includes(permission)
                ) {
                    return true;
                }
            }
        }

        // If no permission found, return false
        return false;
    };

    return {
        hasPermission,
    };
}
