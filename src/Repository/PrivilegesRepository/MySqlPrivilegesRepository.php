<?php

namespace Nebalus\Webapi\Repository\PrivilegesRepository;

use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Exception\ApiInvalidArgumentException;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\Privilege;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\PrivilegeNode;
use PDO;

class MySqlPrivilegesRepository
{
    public function __construct(
        private PDO $pdo,
    ) {
    }

    /**
     * @throws ApiInvalidArgumentException
     * @throws ApiException
     */
    public function findPrivilegeByNode(PrivilegeNode $node): ?Privilege
    {
        $sql = <<<SQL
            SELECT * FROM privileges WHERE node = :node
        SQL;

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue("node", $node->getNode());
        $stmt->execute();

        $data = $stmt->fetch();

        if (!$data) {
            return null;
        }

        return Privilege::fromArray($data);
    }
}
