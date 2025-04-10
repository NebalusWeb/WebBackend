<?php

namespace Nebalus\Webapi\Value\User\AccessControl\Privilege;

use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Exception\ApiInvalidArgumentException;

readonly class Privilege
{
    public function __construct(
        private PrivilegeId $privilegeId,
        private PrivilegeNode $node,
        private PrivilegeDescription $description,
        private bool $isPrestige,
        private ?int $defaultValue
    ) {
    }

    public static function from(
        PrivilegeId $id,
        PrivilegeNode $node,
        PrivilegeDescription $description,
        bool $isPrestige,
        ?int $defaultValue = null
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
        $id = PrivilegeId::from($value['privilege_id']);
        $node = PrivilegeNode::fromString($value['node'], false); // TODO Muss noch ein extra value object bauen, die nicht grantAllSubPrivileges beinhaltet
        $description = PrivilegeDescription::from($value['description']);
        $isPrestige = (bool) $value['is_prestige'];
        $defaultValue = $value['default_value'] ?? null;

        return new self($id, $node, $description, $isPrestige, $defaultValue);
    }

    public function asArray(): array
    {
        return [
            'privilege_id' => $this->privilegeId->asInt(),
            'node' => $this->node->getNode(),
            'description' => $this->description->asString(),
            'is_prestige' => $this->isPrestige,
            'default_value' => $this->defaultValue,
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

    public function getDefaultValue(): ?int
    {
        return $this->defaultValue;
    }

    public function hasDefaultValue(): bool
    {
        return $this->defaultValue !== null;
    }
}
