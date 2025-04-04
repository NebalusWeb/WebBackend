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
    ): self {
        return new self(
            $roleId,
            $roleName,
            $applyOnUserCreation,
            $deletable,
            $createdAtDate,
            $updatedAtDate
        );
    }

    public function getRoleId(): ?RoleId
    {
        return $this->roleId;
    }

    public function getName(): RoleName
    {
        return $this->roleName;
    }

    public function isApplyOnUserCreation(): bool
    {
        return $this->applyOnUserCreation;
    }

    public function isDeletable(): bool
    {
        return $this->deletable;
    }

    public function getCreatedAtDate(): DateTimeImmutable
    {
        return $this->createdAtDate;
    }

    public function getUpdatedAtDate(): DateTimeImmutable
    {
        return $this->updatedAtDate;
    }
}
