<?php

declare(strict_types=1);

namespace Nebalus\Webapi\ValueObject\Referral;

use DateTime;

class Referral
{
    private int $dbId;
    private int $dbUserId;
    private string $code;
    private string $pointer;
    private int $viewCount;
    private DateTime $creationDate;
    private bool $enabled;

    private function __construct(int $dbId, int $dbUserId, string $code, string $pointer, int $viewCount, DateTime $creationDate, bool $enabled)
    {
        $this->dbId = $dbId;
        $this->dbUserId = $dbUserId;
        $this->code = $code;
        $this->pointer = $pointer;
        $this->viewCount = $viewCount;
        $this->creationDate = $creationDate;
        $this->enabled = $enabled;
    }

    public static function from(int $dbId, int $dbUserId, string $code, string $pointer, int $viewCount, DateTime $creationDate, bool $enabled): Referral
    {
        return new Referral($dbId, $dbUserId, $code, $pointer, $viewCount, $creationDate, $enabled);
    }
    public function getDbId(): int
    {
        return $this->dbId;
    }
    public function getDbUserId(): int
    {
        return $this->dbUserId;
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
