<?php

namespace Nebalus\Webapi\Value\User\AccessControl\Role;

use Nebalus\Webapi\Value\User\AccessControl\Permission\PermissionRoleLinkCollection;

class RoleWithPermissions
{
    private function __construct(
        private readonly Role $role,
        private readonly PermissionRoleLinkCollection $permissionLinks,
    ) {
    }

    public static function from(Role $role, PermissionRoleLinkCollection $permissionLinks): self
    {
        return new self($role, $permissionLinks);
    }

    public function getRole(): Role
    {
        return $this->role;
    }

    public function getPermissionLinks(): PermissionRoleLinkCollection
    {
        return $this->permissionLinks;
    }
}
