<?php

namespace Nebalus\Webapi\Repository;

use DateTime;
use Exception;
use Nebalus\Webapi\ValueObject\Account\AccountObject;
use Nebalus\Webapi\ValueObject\Referral\ReferralObject;
use PDO;

class MySqlReferralRepository
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

    public function setViewCountByCode(string $code, int $viewcount): bool
    {
        $sql = "UPDATE `referrals` SET `viewcount`=:viewcount WHERE BINARY `code`=:code";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            "code" => $code,
            "viewcount" => $viewcount
        ]);
    }

    public function getReferralByCode(string $code): ReferralObject|false
    {
        $sql = "SELECT `id`, `accountid`, `code`, `pointer`, `viewcount`, `creationdate`, `enabled` FROM `referrals` WHERE BINARY `code` = :code";
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            "code" => $code
        ]);

        if ($entry = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $creationDate = new DateTime($entry["creationdate"]);
            return ReferralObject::from($entry["id"], $entry["accountid"], $entry["code"], $entry["pointer"], $entry["viewcount"], $creationDate, $entry["enabled"]);
        }
        return false;
    }
}
