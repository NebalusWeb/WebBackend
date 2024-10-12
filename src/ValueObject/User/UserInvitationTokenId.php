<?php

namespace Nebalus\Webapi\ValueObject\User;

use InvalidArgumentException;

readonly class UserInvitationTokenId
{
    private function __construct(
        private int $userInvitationTokenId,
    ) {
    }

    public static function from(int $userId): self
    {
        if ($userId < 0) {
            throw new InvalidArgumentException(
                'Invalid userInvitationTokenId: must be a non-negative integer'
            );
        }

        return new self($userId);
    }

    public function asInt(): int
    {
        return $this->userInvitationTokenId;
    }

    public function __toString(): string
    {
        return (string) $this->userInvitationTokenId;
    }
}
