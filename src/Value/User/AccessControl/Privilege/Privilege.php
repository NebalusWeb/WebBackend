<?php

namespace Nebalus\Webapi\Value\User\AccessControl\Privilege;

class Privilege
{
    public function __construct(
        private readonly PrivilegeId $privilegeId,
        private readonly PrivilegeNode $node,
        private readonly PrivilegeDescription $description,
    ) {
    }

    public static function from(
        PrivilegeId $id,
        PrivilegeNode $node,
        PrivilegeDescription $description
    ): self {
        return new self(
            $id,
            $node,
            $description
        );
    }

    public function getPrivilegeId(): PrivilegeId
    {
        return $this->privilegeId;
    }

    public function getNode(): PrivilegeNode
    {
        return $this->node;
    }

    public function getDescription(): PrivilegeDescription
    {
        return $this->description;
    }
}
