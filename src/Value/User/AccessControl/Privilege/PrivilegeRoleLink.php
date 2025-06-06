<?php

namespace Nebalus\Webapi\Value\User\AccessControl\Privilege;

use Nebalus\Webapi\Exception\ApiException;

class PrivilegeRoleLink
{
    private function __construct(
        private readonly PrivilegeNode $node,
        private readonly PrivilegeRoleLinkMetadata $metadata
    ) {
    }

    public static function from(PrivilegeNode $node, bool $affectsAllSubPrivileges, bool $isBlacklisted, ?PrivilegeValue $value = null): self
    {
        $metadata = PrivilegeRoleLinkMetadata::from($affectsAllSubPrivileges, $isBlacklisted, $value);
        return new self($node, $metadata);
    }

    public function getNode(): PrivilegeNode
    {
        return $this->node;
    }

    public function getMetadata(): PrivilegeRoleLinkMetadata
    {
        return $this->metadata;
    }
}
