<?php

namespace Nebalus\Webapi\Value\User\AccessControl\Role;

use Nebalus\Webapi\Value\User\AccessControl\Privilege\PrivilegeRoleLinkCollection;

class RoleWithPrivileges
{
    private function __construct(
        private readonly Role $role,
        private readonly PrivilegeRoleLinkCollection $privilegeLinks,
    ) {
    }

    public static function from(Role $role, PrivilegeRoleLinkCollection $privilegeLinks): self
    {
        return new self($role, $privilegeLinks);
    }

    public function getRole(): Role
    {
        return $this->role;
    }

    public function getPrivilegeLinks(): PrivilegeRoleLinkCollection
    {
        return $this->privilegeLinks;
    }
}
