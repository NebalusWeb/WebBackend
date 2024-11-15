<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Value\User;

use DateMalformedStringException;
use DateTimeImmutable;
use Nebalus\Webapi\Exception\ApiUnableToBuildValueObjectException;
use Nebalus\Webapi\Value\ID;
use Nebalus\Webapi\Value\User\Totp\TOTPSecretKey;

readonly class User
{
    private function __construct(
        private ID $userId,
        private Username $username,
        private UserEmail $email,
        private UserPassword $password,
        private TOTPSecretKey $totpSecretKey,
        private UserAdminDescription $adminDescription,
        private bool $isAdmin,
        private bool $disabled,
        private DateTimeImmutable $createdAtDate,
        private DateTimeImmutable $updatedAtDate,
    ) {
    }

    public static function from(
        ID $userId,
        Username $username,
        UserEmail $email,
        UserPassword $password,
        TOTPSecretKey $totpSecretKey,
        UserAdminDescription $adminDescription,
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
            $adminDescription,
            $isAdmin,
            $disabled,
            $createdAtDate,
            $updatedAtDate
        );
    }

    /**
     * @throws DateMalformedStringException
     * @throws ApiUnableToBuildValueObjectException
     */
    public static function fromMySQL(array $data): self
    {
        $userId = ID::from($data['user_id']);
        $username = Username::from($data['username']);
        $email = UserEmail::from($data['email']);
        $password = UserPassword::fromHash($data['password']);
        $totpSecretKey = TOTPSecretKey::from($data['totp_secret_key']);
        $adminDescription = UserAdminDescription::from($data['description_for_admins']);
        $isAdmin = (bool) $data['is_admin'];
        $disabled = (bool) $data['disabled'];
        $createdAtDate = new DateTimeImmutable($data['created_at']);
        $updatedAtDate = new DateTimeImmutable($data['updated_at']);

        return new self(
            $userId,
            $username,
            $email,
            $password,
            $totpSecretKey,
            $adminDescription,
            $isAdmin,
            $disabled,
            $createdAtDate,
            $updatedAtDate
        );
    }

    public function getUserId(): ID
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

    public function getAdminDescription(): UserAdminDescription
    {
        return $this->adminDescription;
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
