<?php

declare(strict_types=1);

namespace Nebalus\Webapi\ValueObject\Referral;

use DateTime;
use Nebalus\Webapi\ValueObject\User\UserId;

readonly class Referral
{
    private function __construct(
        private int $referralId,
        private UserId $userId,
        private string $code,
        private string $pointer,
        private int $viewCount,
        private DateTime $creationDate,
        private bool $enabled
    ) {
    }

    public static function from(int $referralId, UserId $userId, string $code, string $pointer, int $viewCount, DateTime $creationDate, bool $enabled): Referral
    {
        return new Referral($referralId, $userId, $code, $pointer, $viewCount, $creationDate, $enabled);
    }
    public function getReferralId(): int
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
    public function getViewCount(): int
    {
        return $this->viewCount;
    }
    public function getCreationDate(): DateTime
    {
        return $this->creationDate;
    }
    public function isEnabled(): bool
    {
        return $this->enabled;
    }
}
