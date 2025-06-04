<?php

namespace Nebalus\Webapi\Value\User\AccessControl\Privilege\Entity;

use IteratorAggregate;
use Traversable;

class PrivilegeRoleLinkCollection implements IteratorAggregate
{
    private array $privilegeNodes = [];

    private function __construct(PrivilegeRoleLink ...$privilegeNodes)
    {
        $this->privilegeNodes = $privilegeNodes;
    }

    public static function fromObjects(PrivilegeRoleLink ...$privilegeNodes): self
    {
        return new self(...$privilegeNodes);
    }

    public function getIterator(): Traversable
    {
        yield from $this->privilegeNodes;
    }
}
