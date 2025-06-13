<?php

namespace Nebalus\Webapi\Value\User\AccessControl\Privilege;

use Nebalus\Webapi\Exception\ApiException;

class PrivilegeRoleLinkIndex
{
    private array $privilegeNodeIndex = [];

    private function __construct(array $privilegeNodeIndex)
    {
        $this->privilegeNodeIndex = $privilegeNodeIndex;
    }

    /**
     * @throws ApiException
     */
    public static function fromPrivilegeRoleLinkCollections(PrivilegeRoleLinkCollection ...$privilegeRoleLinkCollections): self
    {
        $cache = [];
        foreach ($privilegeRoleLinkCollections as $privilegeRoleLinkCollection) {
            foreach ($privilegeRoleLinkCollection as $privilegeRoleLink) {
                $cache[$privilegeRoleLink->getNode()->asString()] = $privilegeRoleLink->getMetadata();
            }
        }

        $privilegeNodeIndex = $cache;

        return new self($privilegeNodeIndex);
    }

    public static function fromObjects(PrivilegeRoleLink ...$privilegeRoleLinks): self
    {
        $cache = [];
        foreach ($privilegeRoleLinks as $privilegeRoleLink) {
            $cache[$privilegeRoleLink->getNode()->asString()] = $privilegeRoleLink->getMetadata();
        }

        $privilegeNodeIndex = array_replace_recursive([], ...$cache);

        return new self($privilegeNodeIndex);
    }

    public function contains(PrivilegeNode $node): bool
    {
        return isset($this->privilegeNodeIndex[$node->asString()]);
    }

    public function containsSomeNodes(PrivilegeNodeCollection $privilegeNodeCollection): bool
    {
        foreach ($privilegeNodeCollection as $privilegeNode) {
            if ($this->contains($privilegeNode)) {
                return true;
            }
        }
        return false;
    }

    public function asArray(): array
    {
        return $this->privilegeNodeIndex;
    }
}
