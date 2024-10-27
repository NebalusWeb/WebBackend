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
        private DateTimeImmutable $creationDate,
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
        $creationDate = new DateTimeImmutable($data["creation_date"]);
        $enabled = $data["enabled"];

        return new Referral($referralId, $userId, $code, $pointer, $creationDate, $enabled);
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
    public function getCreationDate(): DateTimeImmutable
    {
        return $this->creationDate;
    }
    public function isEnabled(): bool
    {
        return $this->enabled;
    }
}
