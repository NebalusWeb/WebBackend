<?php

namespace Nebalus\Webapi\Value\User\AccessControl\Privilege;

use Nebalus\Webapi\Exception\ApiException;

class PrivilegeRoleLinkIndex
{
    private array $privilegeNodeIndexList = [];

    private function __construct(array $privilegeNodeIndex)
    {
        $this->privilegeNodeIndexList = $privilegeNodeIndex;
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

        return new self($cache);
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

    // TODO
    public function hasAccess(PrivilegeNode $node, bool $strict): bool
    {
        $parts = explode('.', $node->asString());
        $currentNode = '';

        foreach ($parts as $index => $part) {
            $currentNode = $index === 0 ? $part : "$currentNode.$part";
            if (isset($this->privilegeNodeIndexList[$currentNode])) {
                $privilegeMetadata = $this->privilegeNodeIndexList[$currentNode];
                if ($privilegeMetadata instanceof PrivilegeRoleLinkMetadata) {
                    if ($currentNode !== $node->asString() && $privilegeMetadata->affectsAllSubPrivileges()) {
                        return !$privilegeMetadata->isBlacklisted();
                    }
                }
            }
        }

        $finalMetadata = $this->privilegeNodeIndexList[$node->asString()] ?? null;

        if ($strict === false && $finalMetadata === null) {
            return $foundMatchWithStrictModeTurnedOff;
        }

        return $finalMetadata instanceof PrivilegeRoleLinkMetadata && !$finalMetadata->isBlacklisted();
    }

    public function hasAccessToSomeNodes(PrivilegeNodeCollection $privilegeNodeCollection, bool $strict): bool
    {
        foreach ($privilegeNodeCollection as $privilegeNode) {
            if ($this->hasAccess($privilegeNode, $strict)) {
                return true;
            }
        }
        return false;
    }

    public function asArray(): array
    {
        return $this->privilegeNodeIndexList;
    }
}
