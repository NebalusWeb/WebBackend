<?php

namespace Nebalus\Webapi\Value\User\AccessControl\Permission;

use JsonSerializable;
use Nebalus\Webapi\Exception\ApiException;

class PermissionRoleLinkMetadata implements JsonSerializable
{
    private function __construct(
        private readonly bool $affectsAllSubPermissions,
        private readonly ?PermissionValue $value
    ) {
    }

    public static function from(bool $affectsAllSubPermissions, ?PermissionValue $value = null): self
    {
        return new self($affectsAllSubPermissions, $value);
    }

    /**
     * @throws ApiException
     */
    public static function fromArray(array $data): self
    {
        return new self(
            (bool) $data['affects_all_sub_permissions'],
            isset($data['value']) ? PermissionValue::from($data['value']) : null
        );
    }

    public function asArray(): array
    {
        return [
            "affects_all_sub_permissions" => $this->affectsAllSubPermissions,
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

    public function hasValue(): bool
    {
        return $this->value !== null;
    }

    public function getValue(): ?PermissionValue
    {
        return $this->value;
    }
}
