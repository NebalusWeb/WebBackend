<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Value\Referral;

use DateMalformedStringException;
use DateTimeImmutable;
use Nebalus\Webapi\Exception\ApiUnableToBuildValueObjectException;
use Nebalus\Webapi\Value\ID;

readonly class Referral
{
    private function __construct(
        private ID $referralId,
        private ID $userId,
        private ReferralCode $code,
        private string $pointer,
        private bool $disabled,
        private DateTimeImmutable $createdAt,
        private DateTimeImmutable $updatedAt,
    ) {
    }

    /**
     * @throws DateMalformedStringException
     * @throws ApiUnableToBuildValueObjectException
     */
    public static function fromMySql(array $data): self
    {
        $referralId = ID::from($data["referral_id"]);
        $userId = ID::from($data["user_id"]);
        $code = ReferralCode::from($data["code"]);
        $pointer = $data["pointer"];
        $disabled = (bool) $data["disabled"];
        $createdAt = new DateTimeImmutable($data["created_at"]);
        $updatedAt = new DateTimeImmutable($data["updated_at"]);

        return new self($referralId, $userId, $code, $pointer, $disabled, $createdAt, $updatedAt);
    }

    public function getReferralId(): ID
    {
        return $this->referralId;
    }
    public function getUserId(): ID
    {
        return $this->userId;
    }
    public function getCode(): ReferralCode
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
    public function getUpdatedAtDate(): DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
