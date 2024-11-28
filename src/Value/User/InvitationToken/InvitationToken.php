<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Value\User\InvitationToken;

use DateMalformedStringException;
use DateTimeImmutable;
use Nebalus\Webapi\Exception\ApiDateMalformedStringException;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Value\ID;

class InvitationToken
{
    private function __construct(
        private readonly ID $ownerUserId,
        private readonly ?ID $invitedUserId,
        private readonly PureInvitationToken $pureInvitationToken,
        private readonly DateTimeImmutable $createdAtDate,
        private readonly ?DateTimeImmutable $usedAtDate
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
     * @throws ApiException
     */
    public static function fromDatabase(array $data): self
    {
        try {
            $createdAtDate = new DateTimeImmutable($data['created_at']);
            $usedAtDate = empty($data['used_at']) ? null : new DateTimeImmutable($data['used_at']);
        } catch (DateMalformedStringException $exception) {
            throw new ApiDateMalformedStringException($exception);
        }

        $ownerUserId = ID::from($data['owner_user_id']);
        $invitedUserId = empty($data['invited_user_id']) ? null : ID::from($data['invited_user_id']);
        $pureInvitationToken = PureInvitationToken::fromDatabase([
            "token_field_1" => $data['token_field_1'],
            "token_field_2" => $data['token_field_2'],
            "token_field_3" => $data['token_field_3'],
            "token_field_4" => $data['token_field_4'],
            "token_checksum" => $data['token_checksum'],
        ]);

        return new self(
            $ownerUserId,
            $invitedUserId,
            $pureInvitationToken,
            $createdAtDate,
            $usedAtDate
        );
    }

    public function toArray(): array
    {
        return [
            'owner_user_id' => $this->ownerUserId->asInt(),
            'invited_user_id' => $this->invitedUserId->asString(),
            "token_field_1" => $this->pureInvitationToken->getField1()->asString(),
            "token_field_2" => $this->pureInvitationToken->getField2()->asString(),
            "token_field_3" => $this->pureInvitationToken->getField3()->asString(),
            "token_field_4" => $this->pureInvitationToken->getField4()->asString(),
            "token_checksum" => $this->pureInvitationToken->getChecksumField()->asString(),
            "created_at" => $this->createdAtDate->format(DATE_ATOM),
            "used_at" => $this->usedAtDate->format(DATE_ATOM),
        ];
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

    public function getField1(): InvitationTokenField
    {
        return $this->pureInvitationToken->getField1();
    }

    public function getField2(): InvitationTokenField
    {
        return $this->pureInvitationToken->getField2();
    }

    public function getField3(): InvitationTokenField
    {
        return $this->pureInvitationToken->getField3();
    }

    public function getField4(): InvitationTokenField
    {
        return $this->pureInvitationToken->getField4();
    }

    public function getChecksumField(): InvitationTokenField
    {
        return $this->pureInvitationToken->getChecksumField();
    }

    public function isExpired(): bool
    {
        return $this->invitedUserId !== null || $this->usedAtDate !== null;
    }
}
