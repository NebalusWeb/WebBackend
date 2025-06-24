<?php

namespace Nebalus\Webapi\Value\User\AccessControl\Role;

use Exception;
use IteratorAggregate;
use Traversable;

class RoleSortedCollection implements IteratorAggregate
{
    private array $roles;

    private function __construct(Role ...$roles)
    {
        $this->roles = $roles;
    }

    /**
     * @throws Exception
     */
    public static function fromRoleCollectionByAccessLevel(RoleCollection $roleCollection): self
    {
        $sorted = iterator_to_array($roleCollection->getIterator());
        usort($sorted, function (Role $a, Role $b) {
            return $b->getAccessLevel() <=> $a->getAccessLevel();
        });

        return new self(...$sorted);
    }

    public function getIterator(): Traversable
    {
        yield from $this->roles;
    }
}
