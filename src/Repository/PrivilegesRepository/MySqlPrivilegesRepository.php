<?php

namespace Nebalus\Webapi\Repository\PrivilegesRepository;

use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Exception\ApiInvalidArgumentException;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\Privilege;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\PrivilegeCollection;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\PurePrivilegeNode;
use PDO;

class MySqlPrivilegesRepository
{
    public function __construct(
        private PDO $pdo,
    ) {
    }

    /**
     * @throws ApiException
     */
    public function getPrivileges(): PrivilegeCollection
    {
        $sql = <<<SQL
            SELECT 
                * 
            FROM privileges
        SQL;

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $data = [];

        while ($row = $stmt->fetch()) {
            $data[] = Privilege::fromArray($row);
        }

        return PrivilegeCollection::fromObjects(...$data);
    }

    /**
     * @throws ApiInvalidArgumentException
     * @throws ApiException
     */
    public function findPrivilegeByNode(PurePrivilegeNode $node): ?Privilege
    {
        $sql = <<<SQL
            SELECT * FROM privileges WHERE node = :node
        SQL;

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue("node", $node->asString());
        $stmt->execute();

        $data = $stmt->fetch();

        if (!$data) {
            return null;
        }

        return Privilege::fromArray($data);
    }
}
