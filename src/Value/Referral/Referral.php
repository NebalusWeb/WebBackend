<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Value\Referral;

use DateMalformedStringException;
use DateTimeImmutable;
use Nebalus\Webapi\Exception\ApiDateMalformedStringException;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Value\ID;

class Referral
{
    private function __construct(
        private readonly ID $referralId,
        private readonly ID $userId,
        private readonly ReferralCode $code,
        private readonly string $pointer,
        private readonly bool $disabled,
        private readonly DateTimeImmutable $createdAtDate,
        private readonly DateTimeImmutable $updatedAtDate,
    ) {
    }

    /**
     * @throws ApiException
     */
    public static function fromArray(array $data): self
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
    public function toArray(): array
    {
        return [
            "referral_id" => $this->referralId->asInt(),
            "user_id" => $this->userId->asInt(),
            "code" => $this->code->asString(),
            "pointer" => $this->pointer,
            "disabled" => $this->disabled,
            "created_at" => $this->createdAtDate->format(DATE_ATOM),
            "updated_at" => $this->updatedAtDate->format(DATE_ATOM),
        ];
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
