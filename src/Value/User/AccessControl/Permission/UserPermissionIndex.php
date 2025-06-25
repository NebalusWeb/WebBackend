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
     * @throws ApiException
     */
    public function hasAccessTo(PermissionAccess $permissionAccess): bool
    {
        $node = $permissionAccess->getNode()->asString();
        $parts = explode('.', $node);

        $triggerAccess = false;

        $currentNode = '';
        foreach ($parts as $index => $part) {
            $currentNode = $index === 0 ? $part : "$currentNode.$part";

            if (isset($this->permissionNodeIndexList[$currentNode])) {
                $permissionMetadata = $this->permissionNodeIndexList[$currentNode];
                if ($permissionMetadata instanceof PermissionRoleLinkMetadata) {
                    if ($permissionMetadata->affectsAllSubPermissions() && $permissionMetadata->isBlacklisted() && $permissionAccess->isAllowAnywayIfBlacklisted() === false) {
                        return false;
                    }
                    if ($permissionAccess->isAllowAccessWithSubPermission() && str_starts_with($currentNode, $permissionAccess->getNode()->asString())) {
                        if ($permissionMetadata->hasValue() && $permissionAccess->hasValueRange()) {
                            if ($permissionAccess->getValueRange()->isInRange($permissionMetadata->getValue()->asInt())) {
                                return true;
                            }
                            return false;
                        }
                    }
                    if ($permissionMetadata->affectsAllSubPermissions() && $permissionMetadata->isBlacklisted() === false) {
                        $triggerAccess = true;
                    }
                }
            }
        }
        $finalMetadata = $this->permissionNodeIndexList[$node] ?? null;
        if ($finalMetadata instanceof PermissionRoleLinkMetadata) {

        }




        return $finalMetadata instanceof PermissionRoleLinkMetadata && (($finalMetadata->isBlacklisted() === false || $permissionAccess->isAllowAnywayIfBlacklisted()) || ($triggerAccess && ($finalMetadata->isBlacklisted() || $permissionAccess->isAllowAnywayIfBlacklisted())));
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
