<?php

namespace Nebalus\Webapi\Value\User\AccessControl\Privilege;

use Nebalus\Webapi\Exception\ApiException;

class PrivilegeNode
{
    // The diff between PurePrivilegeNode and PrivilegeNode is, that PrivilegeNode has extra metedata (grantAllSubPrivileges and an value)
    private function __construct(
        private readonly PurePrivilegeNode $node,
        private readonly bool $grantAllSubPrivileges,
        private readonly ?int $value
    ) {
    }

    /**
     * @throws ApiException
     */
    public static function fromString(string $node, bool $grantAllSubPrivileges, ?int $value = null): self
    {
        $pureNode = PurePrivilegeNode::fromString($node);

        return new self($pureNode, $grantAllSubPrivileges, $value);
    }

    public function hasValue(): bool
    {
        return $this->value !== null;
    }

    public function getValue(): ?int
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
