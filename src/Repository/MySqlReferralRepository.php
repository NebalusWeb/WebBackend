<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Repository;

use DateMalformedStringException;
use Nebalus\Webapi\Value\ID;
use Nebalus\Webapi\Value\Referral\Referral;
use Nebalus\Webapi\Value\Referral\ReferralCode;
use PDO;

readonly class MySqlReferralRepository
{
    public function __construct(
        private PDO $pdo
    ) {
    }

    public function createReferral(ID $userId, ReferralCode $code, string $pointer, bool $disabled = true): bool
    {
        $sql = "INSERT INTO `referrals`(`user_id`, `code`, `pointer`, `disabled`) VALUES (:user_id, :code, :pointer, :disabled)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':user_id', $userId->asInt());
        $stmt->bindValue(':code', $code->asString());
        $stmt->bindValue(':pointer', $pointer);
        $stmt->bindValue(':disabled', $disabled);
        $stmt->execute();

        return $stmt->rowCount() === 1;
    }

    public function createReferralClickEntry(ID $referralId): bool
    {
        $sql = "INSERT INTO `referral_analytics_clicks`(`referral_id`) VALUES (:referral_id)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':referral_id', $referralId->asInt());
        $stmt->execute();

        return $stmt->rowCount() === 1;
    }

    public function deleteReferralById(ID $id)
    {
    }

    public function deleteReferralByCode(string $code)
    {
    }

    public function updateReferral()
    {
    }

    public function getReferralById(ID $id)
    {
    }

    /**
     * @throws DateMalformedStringException
     */
    public function getReferralByCode(ReferralCode $code): ?Referral
    {
        $sql = "SELECT * FROM `referrals` WHERE BINARY `code` = :code";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':code', $code->asString());
        $stmt->execute();

        $data = $stmt->fetch();

        if (!$data) {
            return null;
        }

        return Referral::fromMySql($data);
    }
}
