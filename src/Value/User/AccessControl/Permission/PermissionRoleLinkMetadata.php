<?php

namespace Nebalus\Webapi\Value\User\AccessControl\Permission;

use JsonSerializable;
use Nebalus\Webapi\Exception\ApiException;

class PermissionRoleLinkMetadata implements JsonSerializable
{
    private function __construct(
        private readonly bool $affectsAllSubPermissions,
        private readonly bool $isBlacklisted,
        private readonly ?PermissionValue $value
    ) {
    }

    public static function from(bool $affectsAllSubPermissions, bool $isBlacklisted, ?PermissionValue $value = null): self
    {
        return new self($affectsAllSubPermissions, $isBlacklisted, $value);
    }

    /**
     * @throws ApiException
     */
    public static function fromArray(array $data): self
    {
        return new self(
            (bool) $data['affects_all_sub_permissions'],
            (bool) $data['is_blacklisted'],
            isset($data['value']) ? PermissionValue::from($data['value']) : null
        );
    }

    public function asArray(): array
    {
        return [
            "affects_all_sub_permissions" => $this->affectsAllSubPermissions,
            "is_blacklisted" => $this->isBlacklisted,
            "value" => $this->value?->asInt(),
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->asArray();
    }

    public function affectsAllSubPermissions(): bool
    {
        return $this->affectsAllSubPermissions;
    }

    public function isBlacklisted(): bool
    {
        return $this->isBlacklisted;
    }

    public function hasValue(): bool
    {
        return $this->value !== null;
    }

    public function getValue(): ?PermissionValue
    {
        return $this->value;
    }
}
