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
        private InvitationTokenField $field1,
        private InvitationTokenField $field2,
        private InvitationTokenField $field3,
        private InvitationTokenField $field4,
        private InvitationTokenField $checksumField,
    ) {
    }

    public static function from(
        InvitationTokenId $invitationTokenId,
        UserId $ownerUserId,
        ?UserId $invitedUserId,
        InvitationTokenField $field1,
        InvitationTokenField $field2,
        InvitationTokenField $field3,
        InvitationTokenField $field4,
        InvitationTokenField $checksumField
    ): self {
        if (self::calculateChecksum($field1, $field2, $field3, $field4) !== $checksumField->asInt()) {
            throw new InvalidArgumentException('Invalid Token: Checksum does not match');
        }

        return new self(
            $invitationTokenId,
            $ownerUserId,
            $invitedUserId,
            $field1,
            $field2,
            $field3,
            $field4,
            $checksumField
        );
    }

    public static function fromMySQL(array $data): self
    {
        $invitationTokenId = InvitationTokenId::from($data['invitation_token_id']);
        $ownerUserId = UserId::from($data['owner_user_id']);
        $invitedUserId = empty($data['invited_user_id']) ? null : UserId::from($data['invited_user_id']);
        $field1 = InvitationTokenField::from($data['token_field_1']);
        $field2 = InvitationTokenField::from($data['token_field_2']);
        $field3 = InvitationTokenField::from($data['token_field_3']);
        $field4 = InvitationTokenField::from($data['token_field_4']);
        $checksumField = InvitationTokenField::from($data['token_field_5']);

        return new self(
            $invitationTokenId,
            $ownerUserId,
            $invitedUserId,
            $field1,
            $field2,
            $field3,
            $field4,
            $checksumField
        );
    }

    private static function calculateChecksum(
        InvitationTokenField $field1,
        InvitationTokenField $field2,
        InvitationTokenField $field3,
        InvitationTokenField $field4,
    ): int {
        $checksum = 0;
        $checksum += $field1->asInt();
        $checksum += $field2->asInt();
        $checksum += $field3->asInt();
        $checksum += $field4->asInt();
        $checksum = abs($checksum);
        $checksum /= 4;
        return (int) floor($checksum);
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

    public function getField1(): InvitationTokenField
    {
        return $this->field1;
    }

    public function getField2(): InvitationTokenField
    {
        return $this->field2;
    }

    public function getField3(): InvitationTokenField
    {
        return $this->field3;
    }

    public function getField4(): InvitationTokenField
    {
        return $this->field4;
    }

    public function getChecksumField(): InvitationTokenField
    {
        return $this->checksumField;
    }

    public function getToken(): string
    {
        return sprintf("%s-%s-%s-%s-%s", $this->field1->asString(), $this->field2->asString(), $this->field3->asString(), $this->field4->asString(), $this->checksumField->asString());
    }
}
