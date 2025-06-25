<?php

namespace Nebalus\Webapi\Value\User\AccessControl\Permission;

use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Value\Range;

class PermissionAccess
{
    private function __construct(
        private readonly PermissionNode $node,
        private readonly bool $allowAccessWithSubPermission,
        private readonly bool $allowAnywayIfBlacklisted,
        private readonly ?Range $range
    ) {
    }

    /**
     * @throws ApiException
     */
    public static function from(
        string $node,
        bool $allowAccessWithSubPermission = true,
        bool $allowAnywayIfBlacklisted = false,
        ?Range $range = null
    ): self {
        return new self(PermissionNode::from($node), $allowAccessWithSubPermission, $allowAnywayIfBlacklisted, $range);
    }

    public function getNode(): PermissionNode
    {
        return $this->node;
    }

    public function isAllowAccessWithSubPermission(): bool
    {
        return $this->allowAccessWithSubPermission;
    }

    public function isAllowAnywayIfBlacklisted(): bool
    {
        return $this->allowAnywayIfBlacklisted;
    }

    public function getRange(): ?Range
    {
        return $this->range;
    }
}
