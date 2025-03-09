<?php

namespace Nebalus\Webapi\Value\User\AccessControl\Role;

use DateTimeImmutable;

readonly class Role
{
    public function __construct(
        private ?RoleId $roleId,
        private RoleName $roleName,
        private bool $applyOnUserCreation,
        private bool $deletable,
        private DateTimeImmutable $createdAtDate,
        private DateTimeImmutable $updatedAtDate,
    ) {
    }

    public static function from(
        RoleId $roleId,
        RoleName $roleName,
        bool $applyOnUserCreation,
        bool $deletable,
        DateTimeImmutable $createdAtDate,
        DateTimeImmutable $updatedAtDate
    ) {
        return new self(
            $roleId,
            $roleName,
            $applyOnUserCreation,
            $deletable,
            $createdAtDate,
            $updatedAtDate
        );
    }
}
