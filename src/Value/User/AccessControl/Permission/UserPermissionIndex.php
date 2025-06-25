<?php

namespace Nebalus\Webapi\Value\User\AccessControl\Permission;

use Nebalus\Webapi\Exception\ApiException;

class UserPermissionIndex
{
    private array $permissionNodeIndexList = [];

    private function __construct(array $permissionNodeIndex)
    {
        $this->permissionNodeIndexList = $permissionNodeIndex;
    }

    /**
     * @throws ApiException
     */
    public static function fromPermissionRoleLinkCollections(PermissionRoleLinkCollection ...$privilegeRoleLinkCollections): self
    {
        $cache = [];
        foreach ($privilegeRoleLinkCollections as $privilegeRoleLinkCollection) {
            foreach ($privilegeRoleLinkCollection as $privilegeRoleLink) {
                $cache[$privilegeRoleLink->getNode()->asString()] = $privilegeRoleLink->getMetadata();
            }
        }

        return new self($cache);
    }

    public static function fromObjects(PermissionRoleLink ...$privilegeRoleLinks): self
    {
        $cache = [];
        foreach ($privilegeRoleLinks as $privilegeRoleLink) {
            $cache[$privilegeRoleLink->getNode()->asString()] = $privilegeRoleLink->getMetadata();
        }

        $privilegeNodeIndex = array_replace_recursive([], ...$cache);

        return new self($privilegeNodeIndex);
    }

    /**
     * Checks if the user has access to a specific privilege node.
     * This method traverses the privilege node hierarchy to determine access.
     * @param PermissionNode $node The privilege node to check access for.
     * @param bool $strict If true, the method will only return true if the exact node is found.
     * @throws ApiException
     */
    public function hasAccessTo(PermissionAccess $permissionAccess): bool
    {
        $node = $permissionAccess->getNode()->asString();
        $parts = explode('.', $node);
        $currentNode = '';

        foreach ($parts as $index => $part) {
            $currentNode = $index === 0 ? $part : "$currentNode.$part";
            if (isset($this->permissionNodeIndexList[$currentNode])) {
                $privilegeMetadata = $this->permissionNodeIndexList[$currentNode];
                if ($privilegeMetadata instanceof PermissionRoleLinkMetadata) {
                    if ($currentNode !== $node && $privilegeMetadata->affectsAllSubPermissions()) {
                        return !$privilegeMetadata->isBlacklisted();
                    }
                }
            }
        }

        $finalMetadata = $this->permissionNodeIndexList[$node] ?? null;

        if ($strict === false && $finalMetadata === null) {
            return $foundMatchWithStrictModeTurnedOff;
        }

        return $finalMetadata instanceof PermissionRoleLinkMetadata && !$finalMetadata->isBlacklisted();
    }

    /**
     * @throws ApiException
     */
    public function hasAccessToAtLeastOneNode(PermissionAccessCollection $permissionAccessCollection): bool
    {
        foreach ($permissionAccessCollection as $permissionAccess) {
            if ($this->hasAccessTo($permissionAccess)) {
                return true;
            }
        }
        return false;
    }

    public function asArray(): array
    {
        return $this->permissionNodeIndexList;
    }
}
