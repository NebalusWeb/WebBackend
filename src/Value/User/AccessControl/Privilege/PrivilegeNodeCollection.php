<?php

namespace Nebalus\Webapi\Value\User\AccessControl\Privilege;

use IteratorAggregate;

class PrivilegeNodeCollection implements IteratorAggregate
{
    private array $privilegeNodes = [];

    private function __construct(PrivilegeNode ...$privilegeNodes)
    {
        $this->privilegeNodes = $privilegeNodes;
    }

    public static function fromObjects(PrivilegeNode ...$privilegeNodes): self
    {
        return new self(...$privilegeNodes);
    }

    public function contains(PrivilegeNode $node): bool
    {
        foreach ($this->privilegeNodes as $privilegeNode) {
            if (str_starts_with($privilegeNode->asString(), $node->asString())) {
                return true;
            }
        }
        return false;
    }

    // TODO: NOT FINISHED
    public function containsSomeNodes(PrivilegeNodeCollection $nodeCollection): bool
    {
        $nodeCollection->privilegeNodes = array_filter($nodeCollection->privilegeNodes, function (PrivilegeNode $node) {
            return $this->contains($node);
        });
        foreach ($this->privilegeNodes as $privilegeNode) {
            if (str_starts_with($privilegeNode->asString(), $node->asString())) {
                return true;
            }
        }
        return false;
    }

    public function getIterator(): \Traversable
    {
        yield from $this->privilegeNodes;
    }
}
