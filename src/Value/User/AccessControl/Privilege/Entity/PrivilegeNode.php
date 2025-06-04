<?php

namespace Nebalus\Webapi\Value\User\AccessControl\Privilege\Entity;

use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\PrivilegeValue;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\PurePrivilegeNode;

class PrivilegeNode
{
    // The diff between PurePrivilegeNode and PrivilegeNode is, that PrivilegeNode has extra metedata (grantAllSubPrivileges and an value)
    private function __construct(
        private readonly PurePrivilegeNode $node,
        private readonly bool $grantAllSubPrivileges,
        private readonly ?PrivilegeValue $value
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
