<?php

namespace Nebalus\Webapi\Value\User\AccessControl\Role;

class RoleCollection
{
    private array $roles = [];

    private function __construct(Role ...$roles)
    {
        $this->roles = $roles;
    }

    public static function fromObjects(Role ...$roles): self
    {
        return new self(...$roles);
    }

    public function getIterator(): \Traversable
    {
        yield from $this->roles;
    }
}
