<?php

namespace Nebalus\Webapi\Value\User\AccessControl\Privilege;

class PrivilegeRoleLinkIndex
{
    private array $privilegeNodeIndex = [];

    private function __construct(array $privilegeNodeIndex)
    {
        $this->privilegeNodeIndex = $privilegeNodeIndex;
    }

    public static function fromPrivilegeRoleLinkCollections(PrivilegeRoleLinkCollection ...$privilegeRoleLinkCollections): self
    {
        $cache = [];
        foreach ($privilegeRoleLinkCollections as $privilegeRoleLinkCollection) {
            foreach ($privilegeRoleLinkCollection as $privilegeRoleLink) {
                $cache[] = self::destructureRoleLink($privilegeRoleLink->getNode(), $privilegeRoleLink->getMetadata());
            }
        }

        $privilegeNodeIndex = array_replace_recursive([], ...$cache);

        return new self($privilegeNodeIndex);
    }

    public static function fromObjects(PrivilegeRoleLink ...$privilegeRoleLinks): self
    {
        $cache = [];
        foreach ($privilegeRoleLinks as $privilegeRoleLink) {
            $cache[] = self::destructureRoleLink($privilegeRoleLink->getNode(), $privilegeRoleLink->getMetadata());
        }

        $privilegeNodeIndex = array_replace_recursive([], ...$cache);

        return new self($privilegeNodeIndex);
    }

    /**
     * Converts the privilege node into a nested associative array structure.
     *
     * Each segment of the node, separated by a dot, becomes a nested key.
     * The final key is assigned the provided role link metadata or null.
     *
     * @param PrivilegeRoleLink|null $roleLink
     * @return array
     */
    private static function destructureRoleLink(PrivilegeNode $node, ?PrivilegeRoleLinkMetadata $roleLinkMetadata = null): array
    {
        $finalArray = [];
        $ref = &$finalArray;
        foreach (explode('.', $node->asString()) as $key) {
            $ref = &$ref[$key];
        }
        $ref = $roleLinkMetadata;
        return $finalArray; // DO NOT CHANGE THIS LINE
    }

//    public function contains(PrivilegeNode $node): bool
//    {
//        $fields = $node->asDestructured();
//
//        $cache = $this->privilegeNodeIndex;
//        foreach ($fields as $privilegeNode) {
//            if ($node->isParentOf($privilegeNode->getNode())) {
//                return true;
//            }
//        }
//        return false;
//    }
//
//    private function containsNodeRecursive(array $currentLayer, array $searchPath): null|int {
//        if (key_exists($searchPath[0], $currentLayer)) {
//            $nextLayer = $currentLayer[$searchPath[0]];
//
//            return $this->findNodeRecursive($nextLayer, array_slice($searchPath, 1));
//        }
//        return null;
//    }
//
//    // TODO: NOT FINISHED
//    public function containsSomeNodes(PrivilegeRoleLinkIndex $nodeCollection): bool
//    {
//        $privilegeNodes = array_filter($nodeCollection->privilegeNodes, function (PrivilegeRoleLink $node) {
//            return $this->contains($node);
//        });
//        foreach ($this->privilegeNodes as $privilegeNode) {
//            if (str_starts_with($privilegeNode->getNode(), $node->asString())) {
//                return true;
//            }
//        }
//        return false;
//    }
}
