<?php

namespace Nebalus\Webapi\Repository;

use DateTime;
use Nebalus\Webapi\ValueObjects\Account\AccountObject;
use PDO;

class MySqlRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAccountFromId(int $id): AccountObject
    {
        $sql = "SELECT `id`, `creationdate`, `username` FROM `accounts` WHERE `id` = :id";
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'id' => $id
        ]);

        $values = $stmt->fetch(PDO::FETCH_ASSOC);
        $creationDate = new DateTime($values["creationdate"]);

        return AccountObject::from($values["id"], $creationDate, $values["username"]);
    }

    public function createReferral(string $code, string $pointer)
    {
    }

    public function deleteReferralById(int $id)
    {
    }

    public function deleteReferralByCode(string $code)
    {
    }

    public function updateReferral()
    {
    }

    public function getReferralById(int $id)
    {
    }

    public function getReferralByCode(string $code)
    {
        $sql = "SELECT `id`, `code`, `pointer`, `count`, `creationdate`, `enabled` FROM `referrals` WHERE `code` = :code";
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            "code" => $code
        ]);

        var_dump($stmt->fetch(PDO::FETCH_ASSOC));

        //return MysqlRepositoryResponse::from(false);
    }
}
