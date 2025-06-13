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
                $cache[] = self::destructurePrivilegeNode($privilegeRoleLink->getNode(), $privilegeRoleLink->getMetadata());
            }
        }

        $privilegeNodeIndex = array_replace_recursive([], ...$cache);

        var_dump(json_encode($cache));
        die();
        return new self($privilegeNodeIndex);
    }

    public static function fromObjects(PrivilegeRoleLink ...$privilegeRoleLinks): self
    {
        $cache = [];
        foreach ($privilegeRoleLinks as $privilegeRoleLink) {
            $cache[] = self::destructurePrivilegeNode($privilegeRoleLink->getNode(), $privilegeRoleLink->getMetadata());
        }

        $privilegeNodeIndex = array_replace_recursive([], ...$cache);

        return new self($privilegeNodeIndex);
    }

    public function contains(PrivilegeNode $node): bool
    {
        $nodeNeedle = $node->asDestructured();
        $hayStackIndex = $this->privilegeNodeIndex;

        if ($arrayUtils->inArrayRecursive())

        foreach ($nodeFields as $field) {

            if (is_array($currentIndex) === false || $field === null) {
                return false;
            }
            if (key_exists($field, $currentIndex)) {
                $currentIndex = $currentIndex[$field];
                continue;
            }
            return false;
        }
        var_dump($currentIndex);
        return true;
    }

    public function inArrayRecursive(array $needleArray, array $hayStack): ?PrivilegeRoleLink
    {
        foreach ($needleArray as $key => $needle) {
            if (is_array($needle) && isset($hayStack[$key])) {
                return $this->inArrayRecursive($needle, $hayStack[$key]);
            }
        }
        return null;
    }

/*
 *         foreach ($hayStack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && $)) {
                return true;
            }
        }
 */

    /**
     * Converts the privilege node into a nested associative array structure.
     *
     * Each segment of the node, separated by a dot, becomes a nested key.
     * The final key is assigned the provided role link metadata or null.
     *
     * @param PrivilegeNode $node
     * @param PrivilegeRoleLinkMetadata|null $roleLinkMetadata
     * @return array
     */
    private static function destructurePrivilegeNode(PrivilegeNode $node, ?PrivilegeRoleLinkMetadata $roleLinkMetadata = null): array
    {
        $segments = explode('.', $node->asString());

        // Start with the leaf node (deepest level)
        $current = [
            array_pop($segments) => [
                [
                    'metadata' => $roleLinkMetadata?->asArray(),
                    'children' => null
                ]
            ]
        ];

        // Build upwards
        while (!empty($segments)) {
            $key = array_pop($segments);
            $current = [
                $key => [
                    [
                        'children' => $current
                    ]
                ]
            ];
        }

        return $current; // DO NOT CHANGE THIS LINE
    }



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
//    public function containsSomeNodes(PrivilegeNodeCollection $privilegeNodeCollection): bool
//    {
//
//        $privilegeNodes = array_filter([...$privilegeNodeCollection], function (PrivilegeNode $node) {
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
