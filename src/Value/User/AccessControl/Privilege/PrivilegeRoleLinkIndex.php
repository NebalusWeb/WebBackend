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

    public function hasAccess(PrivilegeNode $node): bool
    {
        $parts = explode('.', $node->asString());
        $currentNode = '';

        foreach ($parts as $index => $part) {
            $currentNode = $index === 0 ? $part : "$currentNode.$part";
            if (isset($this->privilegeNodeIndex[$currentNode])) {
                $privilegeMetadata = $this->privilegeNodeIndex[$currentNode];

                if ($privilegeMetadata instanceof PrivilegeRoleLinkMetadata) {
                    if ($currentNode !== $node->asString() && $privilegeMetadata->affectsAllSubPrivileges()) {
                        return !$privilegeMetadata->isBlacklisted();
                    }
                }
            }
        }

        $finalMetadata = $this->privilegeNodeIndex[$node->asString()] ?? null;
        return $finalMetadata instanceof PrivilegeRoleLinkMetadata && !$finalMetadata->isBlacklisted();
    }

    public function hasAccessToSomeNodes(PrivilegeNodeCollection $privilegeNodeCollection): bool
    {
        foreach ($privilegeNodeCollection as $privilegeNode) {
            if ($this->hasAccess($privilegeNode)) {
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
