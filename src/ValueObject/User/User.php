<?php

declare(strict_types=1);

namespace Nebalus\Webapi\ValueObject\User;

use DateTime;
use DateTimeImmutable;

readonly class User
{
    private function __construct(
        private UserId $userId,
        private Username $username,
        private DateTimeImmutable $creationDate,
    ) {
    }

    public static function from(UserId $dbId, Username $username, DateTimeImmutable $creationDate): self
    {
        return new User($dbId, $username, $creationDate);
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getCreationDate(): DateTimeImmutable
    {
        return $this->creationDate;
    }

    public function getUsername(): Username
    {
        return $this->username;
    }
}
