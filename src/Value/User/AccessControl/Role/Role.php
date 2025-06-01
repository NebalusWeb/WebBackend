<?php

namespace Nebalus\Webapi\Value\User\AccessControl\Role;

use DateTimeImmutable;
use Nebalus\Webapi\Exception\ApiDateMalformedStringException;

class Role
{
    public function __construct(
        private readonly ?RoleId $roleId,
        private readonly RoleName $roleName,
        private readonly ?RoleDescription $roleDescription,
        private readonly bool $appliesToEveryone,
        private readonly bool $deletable,
        private readonly bool $editable,
        private readonly RoleAccessLevel $accessLevel,
        private readonly DateTimeImmutable $createdAtDate,
        private readonly DateTimeImmutable $updatedAtDate,
    ) {
    }

    public static function create(
        RoleName $roleName,
        ?RoleDescription $roleDescription,
        bool $appliesToEveryone,
        bool $deletable,
        bool $editable,
        RoleAccessLevel $accessLevel,
    ): self {
        $createdAtDate = new DateTimeImmutable();
        $updatedAtDate = new DateTimeImmutable();
        return self::from(null, $roleName, $roleDescription, $appliesToEveryone, $deletable, $editable, $accessLevel, $createdAtDate, $updatedAtDate);
    }

    public static function from(
        ?RoleId $roleId,
        RoleName $roleName,
        ?RoleDescription $roleDescription,
        bool $appliesToEveryone,
        bool $deletable,
        bool $editable,
        RoleAccessLevel $accessLevel,
        DateTimeImmutable $createdAtDate,
        DateTimeImmutable $updatedAtDate
    ): self {
        return new self(
            $roleId,
            $roleName,
            $roleDescription,
            $appliesToEveryone,
            $deletable,
            $editable,
            $accessLevel,
            $createdAtDate,
            $updatedAtDate
        );
    }

    public static function fromArray(array $data): self
    {
        try {
            $createdAtDate = new DateTimeImmutable($data['created_at']);
            $updatedAtDate = new DateTimeImmutable($data['updated_at']);
            return new self(
                empty($data['role_id']) ? null : RoleId::from($data['role_id']),
                RoleName::from($data['name']),
                RoleDescription::from($data['description']),
                (bool) $data['applies_to_everyone'],
                (bool) $data['deletable'],
                (bool) $data['editable'],
                RoleAccessLevel::from($data['access_level']),
                $createdAtDate,
                $updatedAtDate
            );
        } catch (\DateMalformedStringException $exception) {
            throw new ApiDateMalformedStringException($exception);
        }

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

    public function isEditable(): bool
    {
        return $this->editable;
    }

    public function getAccessLevel(): RoleAccessLevel
    {
        return $this->accessLevel;
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
