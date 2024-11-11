<?php

namespace Nebalus\Webapi\Value\User\InvitationToken;

class InvitationTokens
{
    private array $invitationsTokens;

    private function __construct(InvitationToken ...$invitationsTokens)
    {
        $this->invitationsTokens = $invitationsTokens;
    }

    public static function fromArray(InvitationToken ...$invitationsTokens): self
    {
        return new self(...$invitationsTokens);
    }

    public function getInvitationTokens(): array
    {
        return $this->invitationsTokens;
    }
}
