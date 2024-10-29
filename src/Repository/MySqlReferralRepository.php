<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Repository;

use DateMalformedStringException;
use DateTime;
use DateTimeImmutable;
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

    public function createReferralClickEntry(ReferralId $id): bool
    {
        $sql = "INSERT INTO `referral_clicks`(`referral_id`) VALUES (:referral_id)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':referral_id', $id->asInt());
        $stmt->execute();

        return $stmt->rowCount() === 1;
    }

    /**
     * @throws DateMalformedStringException
     */
    public function getReferralByCode(string $code): Referral|null
    {
        $sql = "SELECT * FROM `referrals` WHERE BINARY `code` = :code";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':code', $code);
        $stmt->execute();

        $data = $stmt->fetch();

        if (empty($data)) {
            return null;
        }

        return Referral::fromMySql($data);
    }
}
