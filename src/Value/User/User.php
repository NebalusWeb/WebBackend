<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Value\User;

use DateMalformedStringException;
use DateTimeImmutable;
use Nebalus\Webapi\Exception\ApiDateMalformedStringException;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Value\ID;
use Nebalus\Webapi\Value\User\Totp\TOTPSecretKey;

class User
{
    private function __construct(
        private readonly ?ID $userId,
        private readonly Username $username,
        private readonly UserEmail $email,
        private readonly UserPassword $password,
        private readonly TOTPSecretKey $totpSecretKey,
        private readonly UserDescription $description,
        private readonly bool $isAdmin,
        private readonly bool $disabled,
        private readonly DateTimeImmutable $createdAtDate,
        private readonly DateTimeImmutable $updatedAtDate,
    ) {
    }

    /**
     * @throws ApiException
     */
    public function create(Username $username, UserEmail $email, UserPassword $password): self
    {
        $totpSecretKey = TOTPSecretKey::create();
        $description = UserDescription::from(null);
        $createdAtDate = new DateTimeImmutable();
        $updatedAtDate = new DateTimeImmutable();
        return self::from(null, $username, $email, $password, $totpSecretKey, $description, false, false, $createdAtDate, $updatedAtDate);
    }

    public static function from(
        ?ID $userId,
        Username $username,
        UserEmail $email,
        UserPassword $password,
        TOTPSecretKey $totpSecretKey,
        UserDescription $description,
        bool $isAdmin,
        bool $disabled,
        DateTimeImmutable $createdAtDate,
        DateTimeImmutable $updatedAtDate
    ): self {

        return new User(
            $userId,
            $username,
            $email,
            $password,
            $totpSecretKey,
            $description,
            $isAdmin,
            $disabled,
            $createdAtDate,
            $updatedAtDate
        );
    }

    /**
     * @throws ApiException
     */
    public static function fromDatabase(array $data): self
    {
        try {
            $createdAtDate = new DateTimeImmutable($data['created_at']);
            $updatedAtDate = new DateTimeImmutable($data['updated_at']);
        } catch (DateMalformedStringException $exception) {
            throw new ApiDateMalformedStringException($exception);
        }

        $userId = empty($data['user_id']) ? null : ID::from($data['user_id']);
        $username = Username::from($data['username']);
        $email = UserEmail::from($data['email']);
        $password = UserPassword::fromHash($data['password']);
        $totpSecretKey = TOTPSecretKey::from($data['totp_secret_key']);
        $description = UserDescription::from($data['description']);
        $isAdmin = (bool) $data['is_admin'];
        $disabled = (bool) $data['disabled'];

        return new self(
            $userId,
            $username,
            $email,
            $password,
            $totpSecretKey,
            $description,
            $isAdmin,
            $disabled,
            $createdAtDate,
            $updatedAtDate
        );
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->userId?->asInt(),
            'username' => $this->username->asString(),
            'email' => $this->email->asString(),
            'password' => $this->password->asString(),
            'totp_secret_key' => $this->totpSecretKey->asString(),
            'description' => $this->description->asString(),
            'is_admin' => $this->isAdmin,
            'disabled' => $this->disabled,
            'created_at' => $this->createdAtDate->format(DATE_ATOM),
            'updated_at' => $this->updatedAtDate->format(DATE_ATOM),
        ];
    }

    public function getUserId(): ?ID
    {
        return $this->userId;
    }

    public function getUsername(): Username
    {
        return $this->username;
    }

    public function getEmail(): UserEmail
    {
        return $this->email;
    }

    public function getPassword(): UserPassword
    {
        return $this->password;
    }

    public function getTotpSecretKey(): TOTPSecretKey
    {
        return $this->totpSecretKey;
    }

    public function isAdmin(): bool
    {
        return $this->isAdmin;
    }

    public function isDisabled(): bool
    {
        return $this->disabled;
    }

    public function getDescription(): UserDescription
    {
        return $this->description;
    }

    public function getCreatedAtDate(): DateTimeImmutable
    {
        return $this->createdAtDate;
    }

    public function getUpdatedAtDate(): DateTimeImmutable
    {
        return $this->updatedAtDate;
    }
}
