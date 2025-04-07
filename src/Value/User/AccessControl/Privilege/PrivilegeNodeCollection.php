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

    public static function fromArray(PrivilegeNode ...$privilegeNodes): self
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

    public function getIterator(): \Traversable
    {
        yield from $this->privilegeNodes;
    }
}
