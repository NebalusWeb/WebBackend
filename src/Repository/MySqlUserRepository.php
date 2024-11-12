<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Repository;

use DateMalformedStringException;
use Nebalus\Webapi\Exception\ApiDatabaseException;
use Nebalus\Webapi\Value\ID;
use Nebalus\Webapi\Value\User\User;
use Nebalus\Webapi\Value\User\Username;
use PDO;
use PDOException;

readonly class MySqlUserRepository
{
    public function __construct(
        private PDO $pdo
    ) {
    }

    /**
     * @throws ApiDatabaseException|DateMalformedStringException
     */
    public function getUserFromId(ID $userId): User
    {
        try {
            $sql = "SELECT * FROM `users` WHERE `user_id` = :user_id";

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':user_id', $userId->asInt());
            $stmt->execute();

            $data = $stmt->fetch();

            return User::fromMySQL($data);
        } catch (PDOException $e) {
            throw new ApiDatabaseException(
                "Failed to retrieve user data",
                500,
                $e
            );
        }
    }

    /**
     * @throws ApiDatabaseException|DateMalformedStringException
     */
    public function getUserFromUsername(Username $username): ?User
    {
        try {
            $sql = "SELECT * FROM `users` WHERE `username` = :username";

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':username', $username->asString());
            $stmt->execute();

            $data = $stmt->fetch();

            return User::fromMySQL($data);
        } catch (PDOException $e) {
            throw new ApiDatabaseException(
                "Failed to retrieve user data",
                500,
                $e
            );
        }
    }
}
