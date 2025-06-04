<?php

namespace Nebalus\Webapi\Value\User\AccessControl\Privilege;

use IteratorAggregate;
use Traversable;

class PrivilegeNodeCollection implements IteratorAggregate
{
    private array $privilegeNodes;

    private function __construct(PrivilegeNode ...$privilegeNodes)
    {
        $this->privilegeNodes = $privilegeNodes;
    }

    public static function fromObjects(PrivilegeNode ...$privilegeNodes): self
    {
        return new self(...$privilegeNodes);
    }

    public function getIterator(): Traversable
    {
        yield from $this->privilegeNodes;
    }
}
