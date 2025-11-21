<?php

namespace Source\Domain\Shared;

use Source\Domain\Shared\Models\Auth;
use Source\Domain\Shared\Models\Permission as PermissionModel;
use Source\Domain\Shared\Models\LevelPermission;

/**
 * Class Authorization
 * Handles user permission checks.
 * @package Source\Domain\Shared
 */
class Authorization
{
    /**
     * Checks if the currently logged-in user has a specific permission.
     *
     * @param string $permissionName The name of the permission (e.g., 'Events_view', 'Users_edit').
     * @param string $action (Optional) The action being performed (e.g., 'view', 'create', 'edit', 'delete').
     *                       This parameter is kept for potential future granular control, but for now,
     *                       the $permissionName is expected to be specific enough (e.g., 'events_view').
     * @return bool True if the user has the permission, false otherwise.
     */
    public function hasPermission(string $permissionName, string $action = 'view'): bool
    {
        $user = Auth::user();

        // If no user is logged in, they have no permissions.
        if (!$user) {
            return false;
        }

        // Super admin (level 5) has all permissions.
        // Assuming USER_LEVEL_ADMIN is defined in Helpers.php or similar config.
        if (defined('USER_LEVEL_ADMIN') && $user->level_id === USER_LEVEL_ADMIN) {
            return true;
        }

        // For other users, check their assigned level permissions.
        $levelPermissionModel = new LevelPermission();
        $levelPermissionsIds = $levelPermissionModel->findByLevel($user->level_id);

        // If the level has no permissions assigned, then the user has no permissions.
        if (empty($levelPermissionsIds)) {
            return false;
        }

        // Find the ID of the requested permission by its name.
        $permission = (new PermissionModel())->find("name = :name", "name={$permissionName}")->fetch();

        // If the permission itself doesn't exist in the database, then the user cannot have it.
        if (!$permission) {
            return false;
        }

        // Check if the permission ID is in the list of permissions for the user's level.
        return in_array($permission->id, $levelPermissionsIds);
    }
}
