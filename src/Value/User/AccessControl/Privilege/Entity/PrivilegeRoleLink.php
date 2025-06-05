<?php

namespace Nebalus\Webapi\Value\User\AccessControl\Privilege\Entity;

use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\PrivilegeNode;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\PrivilegeValue;

class PrivilegeRoleLink
{
    private function __construct(
        private readonly PrivilegeNode $node,
        private readonly bool $affectsAllSubPrivileges,
        private readonly bool $isBlacklisted,
        private readonly ?PrivilegeValue $value
    ) {
    }

    /**
     * @throws ApiException
     */
    public static function from(PrivilegeNode $node, bool $affectsAllSubPrivileges, bool $isBlacklisted, ?PrivilegeValue $value = null): self
    {
        return new self($node, $affectsAllSubPrivileges, $isBlacklisted, $value);
    }

    public function getNode(): PrivilegeNode
    {
        return $this->node;
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
