<?php

namespace Nebalus\Webapi\Repository\RoleRepository;

use Nebalus\Webapi\Value\User\AccessControl\Role\Role;
use Nebalus\Webapi\Value\User\AccessControl\Role\RoleId;
use PDO;

class MySqlRoleRepository
{
    public function __construct(
        private PDO $pdo
    ) {
    }

    public function findRoleById(RoleId $roleId): ?Role
    {
        $sql = <<<SQL
            SELECT 
                * 
            FROM roles
            WHERE 
                role_id = :role_id
        SQL;

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':role_id', $roleId->asInt());
        $stmt->execute();

        $data = $stmt->fetch();

        if (!$data) {
            return null;
        }

        return Role::fromArray($data);
    }
}
