<?php

namespace Nebalus\Webapi\Value\Linktree\Click;

use IteratorAggregate;
use Traversable;

class LinktreeClicks implements IteratorAggregate
{
    private array $linktreeClicks;

    private function __construct(LinktreeClick ...$linktreeClicks)
    {
        $this->linktreeClicks = $linktreeClicks;
    }

    public static function fromArray(LinktreeClick ...$linktreeClicks): self
    {
        return new self(...$linktreeClicks);
    }

    public function getIterator(): Traversable
    {
        yield from $this->linktreeClicks;
    }
}
