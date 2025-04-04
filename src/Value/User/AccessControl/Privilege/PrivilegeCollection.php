<?php

namespace Nebalus\Webapi\Value\User\AccessControl\Privilege;

use IteratorAggregate;
use Traversable;

class PrivilegeCollection implements IteratorAggregate
{
    private array $privileges = [];

    private function __construct(Privilege ...$privileges)
    {
        $this->privileges = $privileges;
    }

    public static function fromArray(Privilege ...$privileges): self
    {
        return new self(...$privileges);
    }

    public function getIterator(): Traversable
    {
        yield from $this->privileges;
    }
}
