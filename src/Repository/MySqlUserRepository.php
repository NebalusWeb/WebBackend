<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Repository;

use DateTime;
use Exception;
use Nebalus\Webapi\ValueObject\User\User;
use Nebalus\Webapi\ValueObject\User\UserId;
use PDO;

class MySqlUserRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
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
