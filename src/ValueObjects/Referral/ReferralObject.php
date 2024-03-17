<?php

namespace Nebalus\Webapi\ValueObjects\Referral;

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
}
