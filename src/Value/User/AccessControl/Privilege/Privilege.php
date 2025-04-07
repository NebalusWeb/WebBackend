<?php

namespace Nebalus\Webapi\Value\User\AccessControl\Privilege;

use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Exception\ApiInvalidArgumentException;

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

    /**
     * @throws ApiInvalidArgumentException
     * @throws ApiException
     */
    public static function fromArray(array $value): self
    {
        $id = PrivilegeId::from($value['privilege_id']);
        $node = PrivilegeNode::from($value['node']);
        $description = PrivilegeDescription::from($value['description']);

        return new self($id, $node, $description);
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
