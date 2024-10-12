<?php

namespace Nebalus\Webapi\ValueObject\User;

use InvalidArgumentException;

readonly class UserId
{
    private function __construct(
        private int $userId
    ) {
    }

    public static function from(int $userId): self
    {
        if ($userId < 0) {
            throw new InvalidArgumentException(
                'Invalid userid: must be a non-negative integer'
            );
        }

        return new self($userId);
    }

    public function asInt(): int
    {
        return $this->userId;
    }

    public function __toString(): string
    {
        return (string)$this->userId;
    }
}
