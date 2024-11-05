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
        private DateTimeImmutable $createdAtDate,
        private bool $enabled
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
        $createdAtDate = new DateTimeImmutable($data["creation_date"]);
        $enabled = (bool) $data["enabled"];

        return new Referral($referralId, $userId, $code, $pointer, $createdAtDate, $enabled);
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
    public function getCreatedAtDate(): DateTimeImmutable
    {
        return $this->createdAtDate;
    }
    public function isEnabled(): bool
    {
        return $this->enabled;
    }
}
