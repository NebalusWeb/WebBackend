<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Value\Account\InvitationToken;

use DateMalformedStringException;
use DateTimeImmutable;
use Nebalus\Webapi\Exception\ApiDateMalformedStringException;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Value\Account\AccountId;
use Nebalus\Webapi\Value\ID;

readonly class InvitationToken
{
    private function __construct(
        private AccountId $ownerAccountId,
        private ?AccountId $invitedAccountId,
        private PureInvitationToken $pureInvitationToken,
        private DateTimeImmutable $createdAtDate,
        private ?DateTimeImmutable $usedAtDate
    ) {
    }

    public static function from(
        AccountId $ownerAccountId,
        ?AccountId $invitedAccountId,
        PureInvitationToken $pureInvitationToken,
        DateTimeImmutable $creationTimestamp,
        ?DateTimeImmutable $usedTimestamp
    ): self {
        return new self(
            $ownerAccountId,
            $invitedAccountId,
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

        $ownerAccountId = AccountId::from($data['owner_account_id']);
        $invitedAccountId = empty($data['invited_account_id']) ? null : AccountId::from($data['invited_account_id']);
        $pureInvitationToken = PureInvitationToken::from(
            InvitationTokenField::from($data['token_field_1']),
            InvitationTokenField::from($data['token_field_2']),
            InvitationTokenField::from($data['token_field_3']),
            InvitationTokenField::from($data['token_field_4']),
            InvitationTokenField::from($data['token_checksum']),
        );

        return new self($ownerAccountId, $invitedAccountId, $pureInvitationToken, $createdAtDate, $usedAtDate);
    }

    /**
     * @throws ApiException
     */
    public static function fromArray(array $data): self
    {
        try {
            $createdAtDate = new DateTimeImmutable($data['created_at']);
            $usedAtDate = empty($data['used_at']) ? null : new DateTimeImmutable($data['used_at']);
        } catch (DateMalformedStringException $exception) {
            throw new ApiDateMalformedStringException($exception);
        }

        $ownerAccountId = AccountId::from($data['owner_account_id']);
        $invitedAccountId = empty($data['invited_account_id']) ? null : AccountId::from($data['invited_account_id']);
        $pureInvitationToken = PureInvitationToken::fromArray($data['pure_invitation_token']);

        return new self($ownerAccountId, $invitedAccountId, $pureInvitationToken, $createdAtDate, $usedAtDate);
    }

    public function asArray(): array
    {
        return [
            'owner_account_id' => $this->ownerAccountId->asInt(),
            'invited_account_id' => $this->invitedAccountId->asInt(),
            'pure_invitation_token' => $this->pureInvitationToken->asArray(),
            "created_at" => $this->createdAtDate->format(DATE_ATOM),
            "used_at" => $this->usedAtDate->format(DATE_ATOM),
        ];
    }

    public function getOwnerAccountId(): AccountId
    {
        return $this->ownerAccountId;
    }

    public function getInvitedAccountId(): ?AccountId
    {
        return $this->invitedAccountId;
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

    public function setInvitedAccountId(AccountId $newInvitedAccountId): self
    {
        return new self($this->ownerAccountId, $newInvitedAccountId, $this->pureInvitationToken, $this->createdAtDate, new DateTimeImmutable());
    }

    public function isExpired(): bool
    {
        return $this->invitedAccountId !== null || $this->usedAtDate !== null;
    }
}
