<?php

declare(strict_types=1);

namespace Nebalus\Webapi\ValueObject\User;

use DateMalformedStringException;
use DateTimeImmutable;
use Nebalus\Webapi\ValueObject\User\InvitationToken\InvitationTokenId;

readonly class User
{
    private function __construct(
        private UserId $userId,
        private Username $username,
        private Email $email,
        private UserAdminDescription $adminDescription,
        private bool $isAdmin,
        private bool $isEnabled,
        private InvitationTokenId $createdFromInvitationTokenId,
        private DateTimeImmutable $creationDate,
        private DateTimeImmutable $lastTimeUpdated,
    ) {
    }

    public static function from(
        UserId $userId,
        Username $username,
        Email $email,
        UserAdminDescription $adminDescription,
        bool $isAdmin,
        bool $isEnabled,
        InvitationTokenId $createdFromInvitationTokenId,
        DateTimeImmutable $creationDate,
        DateTimeImmutable $lastTimeUpdated
    ): self {

        return new User(
            $userId,
            $username,
            $email,
            $adminDescription,
            $isAdmin,
            $isEnabled,
            $createdFromInvitationTokenId,
            $creationDate,
            $lastTimeUpdated
        );
    }

    /**
     * @throws DateMalformedStringException
     */
    public static function fromMySQL(array $data): self
    {
        $userId = UserId::from($data['user_id']);
        $username = Username::from($data['username']);
        $email = Email::from($data['email']);
        $adminDescription = UserAdminDescription::from($data['description_for_admins']);
        $isAdmin = (bool) $data['is_admin'];
        $isEnabled = (bool) $data['is_enabled'];
        $createdFromInvitationTokenId = InvitationTokenId::from($data['created_from_invitation_token_id']);
        $creationDate = new DateTimeImmutable($data['creation_date']);
        $lastTimeUpdated = new DateTimeImmutable($data['last_time_updated']);

        return new User(
            $userId,
            $username,
            $email,
            $adminDescription,
            $isAdmin,
            $isEnabled,
            $createdFromInvitationTokenId,
            $creationDate,
            $lastTimeUpdated
        );
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getCreationDate(): DateTimeImmutable
    {
        return $this->creationDate;
    }

    public function getUsername(): Username
    {
        return $this->username;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function isAdmin(): bool
    {
        return $this->isAdmin;
    }

    public function isEnabled(): bool
    {
        return $this->isEnabled;
    }
}
