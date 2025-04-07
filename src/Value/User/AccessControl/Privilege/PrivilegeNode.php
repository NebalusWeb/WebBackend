<?php

namespace Nebalus\Webapi\Value\User\AccessControl\Privilege;

class PrivilegeNode
{
    private function __construct(
        private string $node
    ) {
    }

    public static function from(string $node): self
    {
        return new self($node);
    }

    public function asString(): string
    {
        return $this->node;
    }
}
