<?php

namespace Nebalus\Webapi\Value\User\AccessControl\Privilege;

use DateTimeImmutable;
use Nebalus\Webapi\Exception\ApiException;

class PrivilegeNode
{
    // The diff between PurePrivilegeNode and PrivilegeNode is, that PrivilegeNode has extra metedata (grantAllSubPrivileges and an value)
    private function __construct(
        private readonly PrivilegeId $privilegeId,
        private readonly PurePrivilegeNode $node,
        private readonly bool $grantAllSubPrivileges,
        private readonly ?PrivilegeValue $value,
        private readonly DateTimeImmutable $createdAt,
    ) {
    }

    /**
     * @throws ApiException
     */
    public static function fromString(string $node, bool $grantAllSubPrivileges, ?PrivilegeValue $value = null): self
    {
        $pureNode = PurePrivilegeNode::from($node);

        return new self($pureNode, $grantAllSubPrivileges, $value);
    }

    public static function fromArray(array $data): self
    {

    }

    public function hasValue(): bool
    {
        return $this->value !== null;
    }

    public function getValue(): ?PrivilegeValue
    {
        return $this->value;
    }

    public function isGrantingSubPrivileges(): bool
    {
        return $this->grantAllSubPrivileges;
    }

    public function getNode(): PurePrivilegeNode
    {
        return $this->node;
    }
}
