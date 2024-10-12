<?php

declare(strict_types=1);

namespace Nebalus\Webapi\ValueObject\User;

use InvalidArgumentException;

readonly class UserInvitationToken
{
    private function __construct(
        private UserInvitationTokenId $userInvitationTokenId,
        private UserId $userId,
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
