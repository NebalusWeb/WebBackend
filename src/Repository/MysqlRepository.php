<?php

namespace Nebalus\Webapi\Repository;

use PDO;

class MysqlRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
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
