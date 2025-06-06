<?php

namespace Nebalus\Webapi\Value\User\AccessControl\Privilege;

class PrivilegeRoleLinkMetadata
{
    private function __construct(
        private readonly bool $affectsAllSubPrivileges,
        private readonly bool $isBlacklisted,
        private readonly ?PrivilegeValue $value
    ) {
    }

    public static function from(bool $affectsAllSubPrivileges, bool $isBlacklisted, ?PrivilegeValue $value = null): self
    {
        return new self($affectsAllSubPrivileges, $isBlacklisted, $value);
    }

    public function affectsAllSubPrivileges(): bool
    {
        return $this->affectsAllSubPrivileges;
    }

    public function isBlacklisted(): bool
    {
        return $this->isBlacklisted;
    }

    public function hasValue(): bool
    {
        return $this->value !== null;
    }

    public function getValue(): ?PrivilegeValue
    {
        return $this->value;
    }
}
