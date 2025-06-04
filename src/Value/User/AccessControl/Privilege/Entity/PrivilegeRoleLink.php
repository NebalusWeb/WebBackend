<?php

namespace Nebalus\Webapi\Value\User\AccessControl\Privilege\Entity;

use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\PrivilegeValue;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\PrivilegeNode;

class PrivilegeRoleLink
{
    // The diff between PrivilegeNode and PrivilegeNode is, that PrivilegeNode has extra metedata (grantAllSubPrivileges and an value)
    private function __construct(
        private readonly PrivilegeNode   $node,
        private readonly bool            $affectsAllSubPrivileges,
        private readonly bool            $isBlacklisted,
        private readonly ?PrivilegeValue $value
    ) {
    }

    /**
     * @throws ApiException
     */
    public static function fromString(string $node, bool $affectsAllSubPrivileges, bool $isBlacklisted, ?PrivilegeValue $value = null): self
    {
        $pureNode = PrivilegeNode::from($node);

        return new self($pureNode, $affectsAllSubPrivileges, $isBlacklisted, $value);
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

    public function affectsAllSubPrivileges(): bool
    {
        return $this->affectsAllSubPrivileges;
    }

    public function getNode(): PrivilegeNode
    {
        return $this->node;
    }
}
