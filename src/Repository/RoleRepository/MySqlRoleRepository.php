<?php

namespace Nebalus\Webapi\Repository\RoleRepository;

use Nebalus\Webapi\Exception\ApiDateMalformedStringException;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Exception\ApiInvalidArgumentException;
use Nebalus\Webapi\Value\User\AccessControl\Role\Role;
use Nebalus\Webapi\Value\User\AccessControl\Role\RoleAccessLevel;
use Nebalus\Webapi\Value\User\AccessControl\Role\RoleCollection;
use Nebalus\Webapi\Value\User\AccessControl\Role\RoleDescription;
use Nebalus\Webapi\Value\User\AccessControl\Role\RoleId;
use Nebalus\Webapi\Value\User\AccessControl\Role\RoleName;
use PDO;

class MySqlRoleRepository
{
    public function __construct(
        private PDO $pdo
    ) {
    }

    public function insertPrivilegeIntoRole()
    {

    }

    public function getAllRoles(): RoleCollection
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
            $data[] = Role::fromArray($row);
        }

        return RoleCollection::fromObjects(...$data);
    }

    /**
     * @throws ApiException
     */
    public function insertRole(Role $role): Role
    {
        $sql = <<<SQL
            INSERT INTO role
                (name, description, applies_to_everyone, deletable, editable, access_level)
            VALUES 
                (:name, :description, :applies_to_everyone, :deletable, :editable, :access_level)
        SQL;

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':name', $role->getName()->asString());
        $stmt->bindValue(':description', $role->getDescription()->asString());
        $stmt->bindValue(':applies_to_everyone', $role->appliesToEveryone(), PDO::PARAM_BOOL);
        $stmt->bindValue(':deletable', $role->isDeletable(), PDO::PARAM_BOOL);
        $stmt->bindValue(':editable', $role->isEditable(), PDO::PARAM_BOOL);
        $stmt->bindValue(':access_level', $role->getAccessLevel()->asInt(), PDO::PARAM_INT);
        $stmt->bindValue(':created_at', $role->getCreatedAtDate()->format("Y-m-d H:i:s"));
        $stmt->bindValue(':updated_at', $role->getUpdatedAtDate()->format("Y-m-d H:i:s"));
        $stmt->execute();

        $roleToArray = $role->asArray();
        $roleToArray["role_id"] = RoleId::from($this->pdo->lastInsertId())->asInt();

        return Role::fromArray($roleToArray);
    }

    /**
     * @throws ApiException
     */
    public function updateRoleFromRoleId(RoleId $roleId, RoleName $name, RoleDescription $description, bool $appliesToEveryone, bool $deletable, RoleAccessLevel $accessLevel): ?Role
    {
        $sql = <<<SQL
            UPDATE roles
            SET 
                name = :name, 
                description = :description, 
                applies_to_everyone = :applies_to_everyone,
                deletable = :deletable,
                access_level = :access_level
            WHERE 
                role_id = :role_id 
                AND editable = true
        SQL;

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':name', $name->asString());
        $stmt->bindValue(':description', $description->asString());
        $stmt->bindValue(':applies_to_everyone', $appliesToEveryone, PDO::PARAM_BOOL);
        $stmt->bindValue(':deletable', $deletable, PDO::PARAM_BOOL);
        $stmt->bindValue(':access_level', $accessLevel->asInt(), PDO::PARAM_INT);
        $stmt->bindValue(':role_id', $roleId->asInt(), PDO::PARAM_INT);
        $stmt->execute();

        return $this->findRoleById($roleId);
    }

    public function deleteRoleFromRoleId(RoleId $roleId): bool
    {
        $sql = <<<SQL
            DELETE FROM roles 
            WHERE 
                role_id = :role_id 
                AND deletable = true
        SQL;

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':role_id', $roleId->asInt());
        $stmt->execute();

        return $stmt->rowCount() === 1;
    }


    /**
     * @throws ApiInvalidArgumentException
     * @throws ApiException
     * @throws ApiDateMalformedStringException
     */
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
