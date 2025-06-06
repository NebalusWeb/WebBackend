<?php

namespace Nebalus\Webapi\Value\User\AccessControl\Privilege;

class PrivilegeRoleLinkIndex
{
    private array $privilegeNodeIndex = [];

    private function __construct(array $privilegeNodeIndex)
    {
        $this->privilegeNodeIndex = $privilegeNodeIndex;
    }

    public static function fromObjects(PrivilegeRoleLink ...$privilegeRoleLinks): self
    {
        $cache = [];
        foreach ($privilegeRoleLinks as $privilegeRoleLink) {
            $cache[] = $privilegeRoleLink->getNode()->asDestructured($privilegeRoleLink->getMetadata());
        }

        $privilegeNodeIndex = array_replace_recursive([], ...$cache);

        return new self($privilegeNodeIndex);
    }

    public function contains(PrivilegeNode $node): bool
    {
        $fields = $node->asDestructured();

        $cache = $this->privilegeNodeIndex;
        foreach ($fields as $privilegeNode) {
            if ($node->isParentOf($privilegeNode->getNode())) {
                return true;
            }
        }
        return false;
    }

    private function containsNodeRecursive(array $currentLayer, array $searchPath): null|int {
        if (key_exists($searchPath[0], $currentLayer)) {
            $nextLayer = $currentLayer[$searchPath[0]];

            return $this->findNodeRecursive($nextLayer, array_slice($searchPath, 1));
        }
        return null;
    }

    // TODO: NOT FINISHED
    public function containsSomeNodes(PrivilegeRoleLinkIndex $nodeCollection): bool
    {
        $privilegeNodes = array_filter($nodeCollection->privilegeNodes, function (PrivilegeRoleLink $node) {
            return $this->contains($node);
        });
        foreach ($this->privilegeNodes as $privilegeNode) {
            if (str_starts_with($privilegeNode->getNode(), $node->asString())) {
                return true;
            }
        }
        return false;
    }
}
