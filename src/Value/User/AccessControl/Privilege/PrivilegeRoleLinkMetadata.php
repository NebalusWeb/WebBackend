<?php

namespace Nebalus\Webapi\Value\User\AccessControl\Privilege;

use Nebalus\Webapi\Exception\ApiException;

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

    /**
     * @throws ApiException
     */
    public static function fromArray(array $data): self
    {
        return new self(
            (bool) $data['affects_all_sub_privileges'],
            (bool) $data['is_blacklisted'],
            isset($data['value']) ? PrivilegeValue::from($data['value']) : null
        );
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
