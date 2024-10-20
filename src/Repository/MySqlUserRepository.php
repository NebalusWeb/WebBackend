<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Repository;

use DateMalformedStringException;
use DateTime;
use Exception;
use Nebalus\Webapi\ValueObject\User\User;
use Nebalus\Webapi\ValueObject\User\UserHashedPassword;
use Nebalus\Webapi\ValueObject\User\UserId;
use Nebalus\Webapi\ValueObject\User\Username;
use PDO;

class MySqlUserRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @throws DateMalformedStringException
     */
    public function findUserByCredentials(Username $username, UserHashedPassword $hashedPassword): ?User
    {
        $sql = "SELECT * FROM `users` WHERE `username` = :username AND `passwd_hash` = :hashedPassword";
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'username' => $username->asString(),
            'hashedPassword' => $hashedPassword->asString(),
        ]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($data)) {
            return null;
        }

        return User::fromMySQL($data);
    }

    public function getUserFromId(UserId $userId): User
    {
        $sql = "SELECT `user_id`, `creation_date`, `username` FROM `users` WHERE `user_id` = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'user_id' => $user_id
        ]);

        $values = $stmt->fetch(PDO::FETCH_ASSOC);
        $creationDate = new DateTime($values["creation_date"]);

        return User::from($values["user_id"], $creationDate, $values["username"]);
    }
}
