<?php

namespace Nebalus\Webapi\Value\User\InvitationToken;

use InvalidArgumentException;

readonly class InvitationTokenId
{
    private function __construct(
        private int $invitationTokenId,
    ) {
    }

    public static function from(int $invitationTokenId): self
    {
        if ($invitationTokenId < 0) {
            throw new InvalidArgumentException(
                'Invalid userInvitationTokenId: must be a non-negative integer'
            );
        }

        return new self($invitationTokenId);
    }

    public function asInt(): int
    {
        return $this->invitationTokenId;
    }

    public function asString(): string
    {
        return (string) $this->invitationTokenId;
    }
}
