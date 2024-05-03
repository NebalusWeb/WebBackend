<?php

namespace Nebalus\Webapi\Repository;

use DateTime;
use Exception;
use Nebalus\Webapi\ValueObject\Account\AccountObject;
use PDO;

class MySqlAccountRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAccountFromId(int $id): AccountObject
    {
        $sql = "SELECT `id`, `creationdate`, `username` FROM `accounts` WHERE `id` = :id";
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'id' => $id
        ]);

        $values = $stmt->fetch(PDO::FETCH_ASSOC);
        $creationDate = new DateTime($values["creationdate"]);

        return AccountObject::from($values["id"], $creationDate, $values["username"]);
    }
}
