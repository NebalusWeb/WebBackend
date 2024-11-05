<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Repository;

use DateMalformedStringException;
use Nebalus\Webapi\Value\Referral\Referral;
use Nebalus\Webapi\Value\Referral\ReferralId;
use Nebalus\Webapi\Value\User\UserId;
use PDO;

readonly class MySqlReferralRepository
{
    public function __construct(
        private PDO $pdo
    ) {
    }

    public function createReferral(UserId $userId, string $code, string $pointer, bool $disabled = true): bool
    {
        $sql = "INSERT INTO `referrals`(`user_id`, `code`, `pointer`, `disabled`) VALUES (:user_id, :code, :pointer, :disabled)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':user_id', $userId->asInt());
        $stmt->bindValue(':code', $code);
        $stmt->bindValue(':pointer', $pointer);
        $stmt->bindValue(':disabled', $disabled);
        $stmt->execute();

        return $stmt->rowCount() === 1;
    }

    public function createReferralClickEntry(ReferralId $referralId): bool
    {
        $sql = "INSERT INTO `analytics_referral_clicks`(`referral_id`) VALUES (:referral_id)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':referral_id', $referralId->asInt());
        $stmt->execute();

        return $stmt->rowCount() === 1;
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
    public function getReferralByCode(string $code): ?Referral
    {
        $sql = "SELECT * FROM `referrals` WHERE BINARY `code` = :code";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':code', $code);
        $stmt->execute();

        $data = $stmt->fetch();

        if (!$data) {
            return null;
        }

        return Referral::fromMySql($data);
    }
}
