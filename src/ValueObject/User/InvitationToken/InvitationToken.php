<?php

declare(strict_types=1);

namespace Nebalus\Webapi\ValueObject\User\InvitationToken;

use Nebalus\Webapi\ValueObject\User\UserId;

readonly class InvitationToken
{
    private function __construct(
        private InvitationTokenId $invitationTokenId,
        private UserId $userId,
        private InvitationTokenField $field1,
        private InvitationTokenField $field2,
        private InvitationTokenField $field3,
        private InvitationTokenField $field4,
        private InvitationTokenField $field5,
    ) {
    }

    public static function from(
        InvitationTokenId $invitationTokenId,
        UserId $userId,
        InvitationTokenField $field1,
        InvitationTokenField $field2,
        InvitationTokenField $field3,
        InvitationTokenField $field4,
        InvitationTokenField $field5
    ): self {
        return new self(
            $invitationTokenId,
            $userId,
            $field1,
            $field2,
            $field3,
            $field4,
            $field5
        );
    }

    public static function fromMySQL(array $data): self
    {
        $invitationTokenId = InvitationTokenId::from($data['invitation_token_id']);
        $userId = UserId::from($data['user_id']);
        $field1 = InvitationTokenField::from($data['field1']);
        $field2 = InvitationTokenField::from($data['field2']);
        $field3 = InvitationTokenField::from($data['field3']);
        $field4 = InvitationTokenField::from($data['field4']);
        $field5 = InvitationTokenField::from($data['field5']);

        return new self(
            $invitationTokenId,
            $userId,
            $field1,
            $field2,
            $field3,
            $field4,
            $field5
        );
    }

    public function getInvitationTokenId(): InvitationTokenId
    {
        return $this->invitationTokenId;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
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

    public function getField5(): InvitationTokenField
    {
        return $this->field5;
    }

    public function getToken(): string
    {
        return sprintf("%s-%s-%s-%s-%s", $this->field1->asString(), $this->field2->asString(), $this->field3->asString(), $this->field4->asString(), $this->field5->asString());
    }
}
