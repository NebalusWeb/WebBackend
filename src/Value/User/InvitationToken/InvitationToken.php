<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Value\User\InvitationToken;

use DateMalformedStringException;
use DateTimeImmutable;
use Nebalus\Webapi\Exception\ApiInvalidArgumentException;
use Nebalus\Webapi\Value\ID;

readonly class InvitationToken
{
    private function __construct(
        private ID $ownerUserId,
        private ?ID $invitedUserId,
        private PureInvitationToken $pureInvitationToken,
        private DateTimeImmutable $createdAtDate,
        private ?DateTimeImmutable $usedAtDate
    ) {
    }

    public static function from(
        ID $ownerUserId,
        ?ID $invitedUserId,
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
     * @throws ApiInvalidArgumentException
     */
    public static function fromMySQL(array $data): self
    {
        $ownerUserId = ID::from($data['owner_user_id']);
        $invitedUserId = empty($data['invited_user_id']) ? null : ID::from($data['invited_user_id']);
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

    public function getOwnerUserId(): ID
    {
        return $this->ownerUserId;
    }

    public function getInvitedUserId(): ?ID
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
