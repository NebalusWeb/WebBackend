<?php

declare(strict_types=1);

namespace Nebalus\Webapi\ValueObject\User\InvitationToken;

use Nebalus\Webapi\ValueObject\User\UserId;

readonly class InvitationToken
{
    private function __construct(
        private InvitationTokenId $invitationTokenId,
        private UserId $userId,
        private string $token,
    ) {
    }

    public static function from(InvitationTokenId $invitationTokenId, UserId $userId): self
    {
        return new self($invitationTokenId, $userId);
    }

    public function getInvitationTokenId(): InvitationTokenId
    {
        return $this->invitationTokenId;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getToken(): string
    {
        return $this->token;
    }
}
