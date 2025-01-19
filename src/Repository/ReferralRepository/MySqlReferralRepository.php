<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Repository\ReferralRepository;

use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Value\Referral\Referral;
use Nebalus\Webapi\Value\Referral\ReferralCode;
use Nebalus\Webapi\Value\Referral\ReferralId;
use Nebalus\Webapi\Value\Referral\ReferralName;
use Nebalus\Webapi\Value\Referral\ReferralPointer;
use Nebalus\Webapi\Value\Referral\Referrals;
use Nebalus\Webapi\Value\User\UserId;
use PDO;

readonly class MySqlReferralRepository
{
    public function __construct(
        private PDO $pdo
    ) {
    }

    public function insertReferral(UserId $ownerUserId, ReferralCode $code, ReferralPointer $pointer, ReferralName $name, bool $disabled = true): bool
    {
        $sql = <<<SQL
            INSERT INTO referrals
                (owner_user_id, code, pointer, name, disabled) 
            VALUES 
                (:owner_user_id, :code, :pointer, :name, :disabled)
        SQL;

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':owner_user_id', $ownerUserId->asInt());
        $stmt->bindValue(':code', $code->asString());
        $stmt->bindValue(':pointer', $pointer->asString());
        $stmt->bindValue(':name', $name->asString());
        $stmt->bindValue(':disabled', $disabled);
        return $stmt->execute();
    }

    public function insertReferralClickEntry(ReferralId $referralId): bool
    {
        $sql = <<<SQL
            INSERT INTO referral_click_metric
                (referral_id) 
            VALUES 
                (:referral_id)
        SQL;

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':referral_id', $referralId->asInt());
        return $stmt->execute();
    }

    public function deleteReferralByCodeAndOwner(UserId $ownerUserId, ReferralCode $code): bool
    {
        $sql = <<<SQL
            DELETE FROM referrals 
            WHERE 
                owner_user_id = :owner_user_id AND
                code = :code
        SQL;

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':owner_user_id', $ownerUserId->asInt());
        $stmt->bindValue(':code', $code->asString());
        $stmt->execute();

        return $stmt->rowCount() === 1;
    }

    public function updateReferralAndOwner(UserId $ownerUserId, Referral $referral): bool
    {
        $sql = <<<SQL
            UPDATE referrals 
            SET 
                pointer = :pointer, 
                name = :name, 
                disabled = :disabled 
            WHERE 
                owner_user_id = :owner_user_id AND 
                code = :code
        SQL;

//        $stmt = $this->pdo->prepare($sql);
//        $stmt->bindValue(':pointer', $referral->getPointer()->asString());
//        $stmt->bindValue(':name', $referral->getName()->asString());
//        $stmt->bindValue(':owner_user_id', $ownerUserId->asInt());
//        $stmt->bindValue("")
//        $stmt->execute();

        return false;
    }

    /**
     * @throws ApiException
     */
    public function getReferralsFromOwner(UserId $ownerUserId): Referrals
    {
        $sql = <<<SQL
            SELECT * FROM referrals
            WHERE
                owner_user_id = :owner_user_id
        SQL;

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':owner_user_id', $ownerUserId->asInt());
        $stmt->execute();

        $data = [];

        while ($row = $stmt->fetch()) {
            $data[] = Referral::fromArray($row);
        }

        return Referrals::fromArray(...$data);
    }

    /**
     * @throws ApiException
     */
    public function findReferralByCode(ReferralCode $code): ?Referral
    {
        $sql = <<<SQL
            SELECT * FROM referrals 
            WHERE 
                code = :code
        SQL;

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':code', $code->asString());
        $stmt->execute();

        $data = $stmt->fetch();

        if (!$data) {
            return null;
        }

        return Referral::fromArray($data);
    }

    /**
     * @throws ApiException
     */
    public function findReferralByCodeAndOwner(UserId $ownerUserId, ReferralCode $code): ?Referral
    {
        $sql = <<<SQL
            SELECT * FROM referrals
            WHERE 
                owner_user_id = :owner_user_id AND
                code = :code
        SQL;

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':owner_user_id', $ownerUserId->asInt());
        $stmt->bindValue(':code', $code->asString());
        $stmt->execute();

        $data = $stmt->fetch();

        if (!$data) {
            return null;
        }

        return Referral::fromArray($data);
    }
}
