<?php

namespace Nebalus\Webapi\Repository;

use Nebalus\Webapi\ValueObject\User\InvitationToken\InvitationToken;
use Nebalus\Webapi\ValueObject\User\InvitationToken\InvitationTokenId;
use Nebalus\Webapi\ValueObject\User\UserId;
use PDO;

readonly class MySqlUserInvitationTokenRepository
{
    public function __construct(
        private PDO $pdo
    ) {
    }

    public function getInvitationTokenFromUserId(UserId $userId): InvitationToken
    {
        $sql = "SELECT * FROM `user_invitation_tokens` WHERE `user_id` = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'user_id' => $userId->asInt()
        ]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return InvitationToken::fromMySQL($data);
    }
}
