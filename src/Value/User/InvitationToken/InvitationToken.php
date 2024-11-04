<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Value\User\InvitationToken;

use InvalidArgumentException;
use Nebalus\Webapi\Value\User\UserId;

readonly class InvitationToken
{
    private function __construct(
        private InvitationTokenId $invitationTokenId,
        private UserId $ownerUserId,
        private ?UserId $invitedUserId,
        private PureInvitationToken $pureInvitationToken,
    ) {
    }

    public static function from(
        InvitationTokenId $invitationTokenId,
        UserId $ownerUserId,
        ?UserId $invitedUserId,
        PureInvitationToken $pureInvitationToken,
    ): self {
        return new self(
            $invitationTokenId,
            $ownerUserId,
            $invitedUserId,
            $pureInvitationToken,
        );
    }

    public static function fromMySQL(array $data): self
    {
        $invitationTokenId = InvitationTokenId::from($data['invitation_token_id']);
        $ownerUserId = UserId::from($data['owner_user_id']);
        $invitedUserId = empty($data['invited_user_id']) ? null : UserId::from($data['invited_user_id']);
        $pureInvitationToken = PureInvitationToken::fromMySQL($data);

        return new self(
            $invitationTokenId,
            $ownerUserId,
            $invitedUserId,
            $pureInvitationToken
        );
    }

    public function getInvitationTokenId(): InvitationTokenId
    {
        return $this->invitationTokenId;
    }

    public function getOwnerUserId(): UserId
    {
        return $this->ownerUserId;
    }

    public function getInvitedUserId(): UserId
    {
        return $this->invitedUserId;
    }

    public function getPureInvitationToken(): PureInvitationToken
    {
        return $this->pureInvitationToken;
    }
}
