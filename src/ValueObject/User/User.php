<?php

declare(strict_types=1);

namespace Nebalus\Webapi\ValueObject\User;

use DateTime;

readonly class User
{
    private function __construct(
        private UserId $userId,
        private DateTime $creationDate,
        private string $username
    ) {
    }

    public static function from(UserId $dbId, DateTime $creationDate, string $username): self
    {
        return new User($dbId, $creationDate, $username);
    }

    public function getDbId(): int
    {
        return $this->dbId;
    }

    public function getCreationDate(): DateTime
    {
        return $this->creationDate;
    }

    public function getUsername(): string
    {
        return $this->username;
    }
}
