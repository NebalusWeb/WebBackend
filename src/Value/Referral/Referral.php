<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Value\Referral;

use DateMalformedStringException;
use DateTimeImmutable;
use Nebalus\Webapi\Value\User\UserId;

readonly class Referral
{
    private function __construct(
        private ReferralId $referralId,
        private UserId $userId,
        private string $code,
        private string $pointer,
        private bool $disabled,
        private DateTimeImmutable $createdAt,
        private DateTimeImmutable $updatedAt,
    ) {
    }

    /**
     * @throws DateMalformedStringException
     */
    public static function fromMySql(array $data): self
    {
        $referralId = ReferralId::from($data["referral_id"]);
        $userId = UserId::from($data["user_id"]);
        $code = $data["code"];
        $pointer = $data["pointer"];
        $disabled = (bool) $data["disabled"];
        $createdAt = new DateTimeImmutable($data["created_at"]);
        $updatedAt = new DateTimeImmutable($data["updated_at"]);

        return new Referral($referralId, $userId, $code, $pointer, $disabled, $createdAt, $updatedAt);
    }

    public function getReferralId(): ReferralId
    {
        return $this->referralId;
    }
    public function getUserId(): UserId
    {
        return $this->userId;
    }
    public function getCode(): string
    {
        return $this->code;
    }
    public function getPointer(): string
    {
        return $this->pointer;
    }
    public function isDisabled(): bool
    {
        return $this->disabled;
    }
    public function getCreatedAtDate(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
