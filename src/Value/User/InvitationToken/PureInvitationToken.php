<?php

namespace Nebalus\Webapi\Value\User\InvitationToken;

use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Exception\ApiInvalidArgumentException;
use Nebalus\Webapi\Value\ArrayConvertible;

class PureInvitationToken implements ArrayConvertible
{
    private function __construct(
        private readonly InvitationTokenField $field1,
        private readonly InvitationTokenField $field2,
        private readonly InvitationTokenField $field3,
        private readonly InvitationTokenField $field4,
        private readonly InvitationTokenField $checksumField,
    ) {
    }

    /**
     * @throws ApiException
     */
    public static function from(
        int $value1,
        int $value2,
        int $value3,
        int $value4,
        int $checksumValue
    ): self {
        $field1 = InvitationTokenField::from($value1);
        $field2 = InvitationTokenField::from($value2);
        $field3 = InvitationTokenField::from($value3);
        $field4 = InvitationTokenField::from($value4);
        $checksum = InvitationTokenField::from($checksumValue);

        if (self::calculateChecksum($field1, $field2, $field3, $field4) !== $checksum->asInt()) {
            throw new ApiInvalidArgumentException('Invalid Token: Checksum does not match');
        }

        return new self($field1, $field2, $field3, $field4, $checksum);
    }

    /**
     * @throws ApiException
     */
    public static function create(): self
    {
        $field1 = InvitationTokenField::create();
        $field2 = InvitationTokenField::create();
        $field3 = InvitationTokenField::create();
        $field4 = InvitationTokenField::create();
        $checksum = InvitationTokenField::from(self::calculateChecksum($field1, $field2, $field3, $field4));

        return new self($field1, $field2, $field3, $field4, $checksum);
    }

    /**
     * @throws ApiException
     */
    public static function fromArray(array $data): self
    {
        $field1 = InvitationTokenField::from($data['token_field_1']);
        $field2 = InvitationTokenField::from($data['token_field_2']);
        $field3 = InvitationTokenField::from($data['token_field_3']);
        $field4 = InvitationTokenField::from($data['token_field_4']);
        $checksumField = InvitationTokenField::from($data['token_checksum']);

        return new self($field1, $field2, $field3, $field4, $checksumField);
    }

    public function toArray(): array
    {
        return [
            "token_field_1" => $this->field1->asString(),
            "token_field_2" => $this->field2->asString(),
            "token_field_3" => $this->field3->asString(),
            "token_field_4" => $this->field4->asString(),
            "token_checksum" => $this->checksumField->asString(),
        ];
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
