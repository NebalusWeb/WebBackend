<?php

namespace Nebalus\Webapi\Repository;

use Nebalus\Webapi\ValueObject\User\InvitationToken\InvitationToken;
use Nebalus\Webapi\ValueObject\User\UserId;
use PDO;

readonly class MySqlUserInvitationTokenRepository
{
    public function __construct(
        private PDO $pdo
    ) {
    }

    public function getInvitationTokenFromOwnerUserId(UserId $ownerUserId): InvitationToken
    {
        $sql = "SELECT * FROM `user_invitation_tokens` WHERE `owner_user_id` = :owner_user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'owner_user_id' => $ownerUserId->asInt()
        ]);

        $data = $stmt->fetch();

        return InvitationToken::fromMySQL($data);
    }
}
