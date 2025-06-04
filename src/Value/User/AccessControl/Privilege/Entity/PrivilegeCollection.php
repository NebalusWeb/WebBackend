<?php

namespace Nebalus\Webapi\Value\User\AccessControl\Privilege\Entity;

use IteratorAggregate;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\PrivilegeNodeCollection;
use Traversable;

class PrivilegeCollection implements IteratorAggregate
{
    private array $privileges;

    private function __construct(Privilege ...$privileges)
    {
        $this->privileges = $privileges;
    }

    public static function fromObjects(Privilege ...$privileges): self
    {
        return new self(...$privileges);
    }

    public function getNodeCollection(): PrivilegeNodeCollection
    {
        return PrivilegeNodeCollection::fromObjects(...array_map(
            fn(Privilege $privilege) => $privilege->getNode(),
            $this->privileges
        ));
    }

    public function getIterator(): Traversable
    {
        yield from $this->privileges;
    }
}
