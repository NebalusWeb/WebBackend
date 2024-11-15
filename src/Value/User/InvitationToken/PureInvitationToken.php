<?php

namespace Nebalus\Webapi\Value\User\InvitationToken;

use InvalidArgumentException;
use Nebalus\Webapi\Exception\ApiUnableToBuildValueObjectException;

readonly class PureInvitationToken
{
    private function __construct(
        private InvitationTokenField $field1,
        private InvitationTokenField $field2,
        private InvitationTokenField $field3,
        private InvitationTokenField $field4,
        private InvitationTokenField $checksumField,
    ) {
    }

    /**
     * @throws ApiUnableToBuildValueObjectException
     */
    public static function from(
        InvitationTokenField $field1,
        InvitationTokenField $field2,
        InvitationTokenField $field3,
        InvitationTokenField $field4,
        InvitationTokenField $checksumField
    ): self {
        if (self::calculateChecksum($field1, $field2, $field3, $field4) !== $checksumField->asInt()) {
            throw new ApiUnableToBuildValueObjectException('Invalid Token: Checksum does not match');
        }
        return new self($field1, $field2, $field3, $field4, $checksumField);
    }

    /**
     * @throws ApiUnableToBuildValueObjectException
     */
    public static function fromString(
        string $token,
    ): self {
        if (!preg_match('/^(([0-9]{4})-){4}([0-9]{4})$/', $token)) {
            throw new ApiUnableToBuildValueObjectException(
                'PLACEHOLDER'
            );
        }

        $fields = explode("-", $token);

        $field1 = InvitationTokenField::from(intval($fields[0]));
        $field2 = InvitationTokenField::from(intval($fields[1]));
        $field3 = InvitationTokenField::from(intval($fields[2]));
        $field4 = InvitationTokenField::from(intval($fields[3]));
        $checksumField = InvitationTokenField::from(intval($fields[4]));

        return self::from($field1, $field2, $field3, $field4, $checksumField);
    }

    /**
     * @throws ApiUnableToBuildValueObjectException
     */
    public static function fromMySQL(array $data): self
    {
        $field1 = InvitationTokenField::from($data['token_field_1']);
        $field2 = InvitationTokenField::from($data['token_field_2']);
        $field3 = InvitationTokenField::from($data['token_field_3']);
        $field4 = InvitationTokenField::from($data['token_field_4']);
        $checksumField = InvitationTokenField::from($data['token_checksum']);

        return new self($field1, $field2, $field3, $field4, $checksumField);
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

    public function asString(): string
    {
        return sprintf("%s-%s-%s-%s-%s", $this->field1->asString(), $this->field2->asString(), $this->field3->asString(), $this->field4->asString(), $this->checksumField->asString());
    }
}
