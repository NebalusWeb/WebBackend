<?php

namespace Nebalus\Webapi\Value\User\AccessControl\Privilege\Entity;

use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Exception\ApiInvalidArgumentException;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\PrivilegeDescription;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\PrivilegeId;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\PrivilegeNode;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\PrivilegeValue;

class Privilege
{
    public function __construct(
        private readonly PrivilegeId $privilegeId,
        private readonly PrivilegeNode $node,
        private readonly PrivilegeDescription $description,
        private readonly bool $isPrestige,
        private readonly ?PrivilegeValue $defaultValue
    ) {
    }

    public static function from(
        PrivilegeId $id,
        PrivilegeNode $node,
        PrivilegeDescription $description,
        bool $isPrestige,
        ?PrivilegeValue $defaultValue = null
    ): self {
        return new self(
            $id,
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
        $privilegeId = PrivilegeId::from($value['privilege_id']);
        $node = PrivilegeNode::from($value['node']);
        $description = PrivilegeDescription::from($value['description']);
        $isPrestige = (bool) $value['is_prestige'];
        $defaultValue = empty($value['default_value']) ? null : PrivilegeValue::from($value['default_value']);

        return new self($privilegeId, $node, $description, $isPrestige, $defaultValue);
    }

    public function asArray(): array
    {
        return [
            'privilege_id' => $this->privilegeId->asInt(),
            'node' => $this->node->asString(),
            'description' => $this->description->asString(),
            'is_prestige' => $this->isPrestige,
            'default_value' => $this->defaultValue?->asInt(),
        ];
    }

    public function getPrivilegeId(): PrivilegeId
    {
        return $this->privilegeId;
    }

    public function getNode(): PrivilegeNode
    {
        return $this->node;
    }

    public function getDescription(): PrivilegeDescription
    {
        return $this->description;
    }

    public function isPrestige(): bool
    {
        return $this->isPrestige;
    }

    public function getDefaultValue(): ?PrivilegeValue
    {
        return $this->defaultValue;
    }

    public function hasDefaultValue(): bool
    {
        return $this->defaultValue !== null;
    }
}
