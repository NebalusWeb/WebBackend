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

    public static function fromMetadata(PrivilegeNode $node, PrivilegeRoleLinkMetadata $metadata): self
    {
        return new self($node, $metadata);
    }

    /**
     * @throws ApiException
     */
    public static function fromArray(array $data): self
    {
        return new self(
            PrivilegeNode::from($data['node']),
            PrivilegeRoleLinkMetadata::fromArray($data)
        );
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
