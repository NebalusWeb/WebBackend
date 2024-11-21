<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Value\Referral;

use DateMalformedStringException;
use DateTimeImmutable;
use Nebalus\Webapi\Exception\ApiDateMalformedStringException;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Exception\ApiInvalidArgumentException;
use Nebalus\Webapi\Value\ID;

readonly class Referral
{
    private function __construct(
        private ID $referralId,
        private ID $userId,
        private ReferralCode $code,
        private string $pointer,
        private bool $disabled,
        private DateTimeImmutable $createdAtDate,
        private DateTimeImmutable $updatedAtDate,
    ) {
    }

    /**
     * @throws ApiException
     */
    public static function fromDatabase(array $data): self
    {
        try {
            $createdAtDate = new DateTimeImmutable($data["created_at"]);
            $updatedAtDate = new DateTimeImmutable($data["updated_at"]);
        } catch (DateMalformedStringException $exception) {
            throw new ApiDateMalformedStringException($exception);
        }

        $referralId = ID::from($data["referral_id"]);
        $userId = ID::from($data["user_id"]);
        $code = ReferralCode::from($data["code"]);
        $pointer = $data["pointer"];
        $disabled = (bool) $data["disabled"];

        return new self(
            $referralId,
            $userId,
            $code,
            $pointer,
            $disabled,
            $createdAtDate,
            $updatedAtDate
        );
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
        return $this->createdAtDate;
    }
    public function getUpdatedAtDate(): DateTimeImmutable
    {
        return $this->updatedAtDate;
    }
}
