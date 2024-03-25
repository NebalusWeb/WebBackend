<?php

namespace Nebalus\Webapi\ValueObject\Referral;

use DateTime;

class ReferralObject
{
    private int $dbId;
    private int $dbAccountId;
    private string $code;
    private string $pointer;
    private int $viewCount;
    private DateTime $creationDate;
    private bool $enabled;

    private function __construct(int $dbId, int $dbAccountId, string $code, string $pointer, int $viewCount, DateTime $creationDate, bool $enabled)
    {
        $this->dbId = $dbId;
        $this->dbAccountId = $dbAccountId;
        $this->code = $code;
        $this->pointer = $pointer;
        $this->viewCount = $viewCount;
        $this->creationDate = $creationDate;
        $this->enabled = $enabled;
    }

    public static function from(int $dbId, int $dbAccountId, string $code, string $pointer, int $viewCount, DateTime $creationDate, bool $enabled): ReferralObject
    {
        return new ReferralObject($dbId, $dbAccountId, $code, $pointer, $viewCount, $creationDate, $enabled);
    }
    public function getDbId(): int
    {
        return $this->dbId;
    }
    public function getDbAccountId(): int
    {
        return $this->dbAccountId;
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
    public function getCreationTimestamp(): int
    {
        return $this->creationDate->getTimestamp();
    }
    public function isEnabled(): bool
    {
        return $this->enabled;
    }
}
