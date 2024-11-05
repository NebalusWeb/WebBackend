<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Value\User\InvitationToken;

use DateMalformedStringException;
use DateTimeImmutable;
use Nebalus\Webapi\Value\User\UserId;

readonly class InvitationToken
{
    private function __construct(
        private UserId $ownerUserId,
        private ?UserId $invitedUserId,
        private PureInvitationToken $pureInvitationToken,
        private DateTimeImmutable $createdAtDate,
        private ?DateTimeImmutable $usedAtDate
    ) {
    }

    public static function from(
        UserId $ownerUserId,
        ?UserId $invitedUserId,
        PureInvitationToken $pureInvitationToken,
        DateTimeImmutable $creationTimestamp,
        ?DateTimeImmutable $usedTimestamp
    ): self {
        return new self(
            $ownerUserId,
            $invitedUserId,
            $pureInvitationToken,
            $creationTimestamp,
            $usedTimestamp
        );
    }

    /**
     * @throws DateMalformedStringException
     */
    public static function fromMySQL(array $data): self
    {
        $ownerUserId = UserId::from($data['owner_user_id']);
        $invitedUserId = empty($data['invited_user_id']) ? null : UserId::from($data['invited_user_id']);
        $pureInvitationToken = PureInvitationToken::fromMySQL($data);
        $createdAtDate = new DateTimeImmutable($data['created_at']);
        $usedAtDate = empty($data['used_at']) ? null : new DateTimeImmutable($data['used_at']);

        return new self(
            $ownerUserId,
            $invitedUserId,
            $pureInvitationToken,
            $createdAtDate,
            $usedAtDate
        );
    }

    public function getOwnerUserId(): UserId
    {
        return $this->ownerUserId;
    }

    public function getInvitedUserId(): ?UserId
    {
        return $this->invitedUserId;
    }

    public function getPureInvitationToken(): PureInvitationToken
    {
        return $this->pureInvitationToken;
    }

    public function getCreatedAtDate(): DateTimeImmutable
    {
        return $this->createdAtDate;
    }

    public function getUsedAtDate(): ?DateTimeImmutable
    {
        return $this->usedAtDate;
    }

    public function isExpired(): bool
    {
        return $this->invitedUserId !== null || $this->usedAtDate !== null;
    }
}
