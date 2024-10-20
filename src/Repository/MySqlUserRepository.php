<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Repository;

use DateMalformedStringException;
use Nebalus\Webapi\ValueObject\User\User;
use Nebalus\Webapi\ValueObject\User\UserHashedPassword;
use Nebalus\Webapi\ValueObject\User\UserId;
use Nebalus\Webapi\ValueObject\User\Username;
use PDO;

readonly class MySqlUserRepository
{
    public function __construct(
        private PDO $pdo
    ) {
    }

    /**
     * @throws DateMalformedStringException
     */
    public function findUserByCredentials(Username $username, UserHashedPassword $hashedPassword): ?User
    {
        $sql = "SELECT * FROM `users` WHERE `username` = :username AND `passwd_hash` = :hashed_password";
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'username' => $username->asString(),
            'hashed_password' => $hashedPassword->asString(),
        ]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($data)) {
            return null;
        }

        return User::fromMySQL($data);
    }

    /**
     * @throws DateMalformedStringException
     */
    public function getUserFromId(UserId $userId): User
    {
        $sql = "SELECT * FROM `users` WHERE `user_id` = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'user_id' => $userId->asInt()
        ]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return User::fromMySQL($data);
    }
}
