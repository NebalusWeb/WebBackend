<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Repository;

use DateMalformedStringException;
use DateTime;
use Nebalus\Webapi\Value\Referral\Referral;
use Nebalus\Webapi\Value\Referral\ReferralId;
use PDO;

readonly class MySqlReferralRepository
{
    public function __construct(
        private PDO $pdo
    ) {
    }

    public function createReferral(string $code, string $pointer)
    {
    }

    public function deleteReferralById(ReferralId $id)
    {
    }

    public function deleteReferralByCode(string $code)
    {
    }

    public function updateReferral()
    {
    }

    public function getReferralById(ReferralId $id)
    {
    }

    /**
     * @throws DateMalformedStringException
     */
    public function getReferralByCode(string $code): Referral|false
    {
        $sql = "SELECT `referral_id`, `user_id`, `code`, `pointer`, `creation_date`, `enabled` FROM `referrals` WHERE BINARY `code` = :code";
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            "code" => $code
        ]);

        if ($entry = $stmt->fetch()) {
            return Referral::fromMySql($entry);
        }
        return false;
    }
}
