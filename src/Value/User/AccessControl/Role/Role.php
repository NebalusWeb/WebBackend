<?php

namespace Nebalus\Webapi\Value\User\AccessControl\Role;

use DateTimeImmutable;

class Role
{
    public function __construct(
        private readonly ?RoleId $roleId,
        private readonly RoleName $roleName,
        private readonly ?RoleDescription $roleDescription,
        private readonly bool $appliesToEveryone,
        private readonly bool $deletable,
        private readonly DateTimeImmutable $createdAtDate,
        private readonly DateTimeImmutable $updatedAtDate,
    ) {
    }

    public static function create(
        RoleName $roleName,
        ?RoleDescription $roleDescription,
        bool $appliesToEveryone,
        bool $deletable,
    ): self {
        $createdAtDate = new DateTimeImmutable();
        $updatedAtDate = new DateTimeImmutable();
        return self::from(null, $roleName, $roleDescription, $appliesToEveryone, $deletable, $createdAtDate, $updatedAtDate);
    }

    public static function from(
        ?RoleId $roleId,
        RoleName $roleName,
        ?RoleDescription $roleDescription,
        bool $appliesToEveryone,
        bool $deletable,
        DateTimeImmutable $createdAtDate,
        DateTimeImmutable $updatedAtDate
    ): self {
        return new self(
            $roleId,
            $roleName,
            $roleDescription,
            $appliesToEveryone,
            $deletable,
            $createdAtDate,
            $updatedAtDate
        );
    }

    public static function fromArray(array $data): self
    {
        return new self();
    }

    public function getRoleId(): ?RoleId
    {
        return $this->roleId;
    }

    public function getName(): RoleName
    {
        return $this->roleName;
    }

    public function getDescription(): ?RoleDescription
    {
        return $this->roleDescription;
    }

    public function appliesToEveryone(): bool
    {
        return $this->appliesToEveryone;
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
