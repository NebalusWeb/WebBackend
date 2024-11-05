<?php

namespace Nebalus\Webapi\Value\Referral;

use Nebalus\Webapi\Value\User\InvitationToken\InvitationToken;

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
