<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Value\User;

use DateMalformedStringException;
use DateTimeImmutable;

readonly class User
{
    private function __construct(
        private UserId $userId,
        private Username $username,
        private UserAdminDescription $adminDescription,
        private bool $isAdmin,
        private bool $isEnabled,
        private DateTimeImmutable $createdAtDate,
        private DateTimeImmutable $updatedAtDate,
    ) {
    }

    public static function from(
        UserId $userId,
        Username $username,
        UserAdminDescription $adminDescription,
        bool $isAdmin,
        bool $isEnabled,
        DateTimeImmutable $createdAtDate,
        DateTimeImmutable $updatedAtDate
    ): self {

        return new User(
            $userId,
            $username,
            $adminDescription,
            $isAdmin,
            $isEnabled,
            $createdAtDate,
            $updatedAtDate
        );
    }

    /**
     * @throws DateMalformedStringException
     */
    public static function fromMySQL(array $data): self
    {
        $userId = UserId::from($data['user_id']);
        $username = Username::from($data['username']);
        $adminDescription = UserAdminDescription::from($data['description_for_admins']);
        $isAdmin = (bool) $data['is_admin'];
        $isEnabled = (bool) $data['is_enabled'];
        $createdAtDate = new DateTimeImmutable($data['created_at']);
        $updatedAtDate = new DateTimeImmutable($data['updated_at']);

        return new User(
            $userId,
            $username,
            $adminDescription,
            $isAdmin,
            $isEnabled,
            $createdAtDate,
            $updatedAtDate
        );
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }
    public function getUsername(): Username
    {
        return $this->username;
    }

    public function isAdmin(): bool
    {
        return $this->isAdmin;
    }

    public function isEnabled(): bool
    {
        return $this->isEnabled;
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
