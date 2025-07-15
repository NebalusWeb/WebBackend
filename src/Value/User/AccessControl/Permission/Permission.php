<?php

namespace Nebalus\Webapi\Value\User\AccessControl\Permission;

use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Exception\ApiInvalidArgumentException;

readonly class Permission
{
    private function __construct(
        private PermissionId $permissionId,
        private PermissionNode $node,
        private PermissionDescription $description,
        private bool $isPrestige,
        private ?PermissionValue $defaultValue
    ) {
    }

    public static function from(
        PermissionId $permissionId,
        PermissionNode $node,
        PermissionDescription $description,
        bool $isPrestige,
        ?PermissionValue $defaultValue = null
    ): self {
        return new self(
            $permissionId,
            $node,
            $description,
            $isPrestige,
            $defaultValue
        );
    }

    /**
     * @throws ApiInvalidArgumentException
     * @throws ApiException
     */
    public static function fromArray(array $value): self
    {
        $permissionId = PermissionId::from($value['permission_id']);
        $node = PermissionNode::from($value['node']);
        $description = PermissionDescription::from($value['description']);
        $isPrestige = (bool) $value['is_prestige'];
        $defaultValue = empty($value['default_value']) ? null : PermissionValue::from($value['default_value']);

        return new self($permissionId, $node, $description, $isPrestige, $defaultValue);
    }

    public function asArray(): array
    {
        return [
            'permission_id' => $this->permissionId->asInt(),
            'node' => $this->node->asString(),
            'description' => $this->description->asString(),
            'is_prestige' => $this->isPrestige,
            'default_value' => $this->defaultValue?->asInt(),
        ];
    }

    public function getPermissionId(): PermissionId
    {
        return $this->permissionId;
    }

    public function getNode(): PermissionNode
    {
        return $this->node;
    }

    public function getDescription(): PermissionDescription
    {
        return $this->description;
    }

    public function isPrestige(): bool
    {
        return $this->isPrestige;
    }

    public function getDefaultValue(): ?PermissionValue
    {
        return $this->defaultValue;
    }

    public function hasDefaultValue(): bool
    {
        return $this->defaultValue !== null;
    }
}
