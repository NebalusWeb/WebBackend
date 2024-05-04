<?php

namespace Nebalus\Webapi\ValueObject\User;

use DateTime;

class UserObject
{
    private int $dbId;
    private DateTime $creationDate;
    private string $username;

    private function __construct(int $dbId, DateTime $creationDate, string $username)
    {
        $this->dbId = $dbId;
        $this->creationDate = $creationDate;
        $this->username = $username;
    }

    public static function from(int $dbId, DateTime $creationDate, string $username): self
    {
        return new UserObject($dbId, $creationDate, $username);
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
