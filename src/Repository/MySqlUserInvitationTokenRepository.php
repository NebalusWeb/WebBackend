<?php

namespace Nebalus\Webapi\Repository;

use Nebalus\Webapi\Value\Referral\InvitationTokens;
use Nebalus\Webapi\Value\User\InvitationToken\InvitationToken;
use Nebalus\Webapi\Value\User\InvitationToken\PureInvitationToken;
use Nebalus\Webapi\Value\User\UserId;
use PDO;

readonly class MySqlUserInvitationTokenRepository
{
    public function __construct(
        private PDO $pdo
    ) {
    }

    public function findInvitationTokenByFields(PureInvitationToken $token): ?InvitationToken {
        $sql = "SELECT * FROM `user_invitation_tokens` WHERE `token_field_1` = :token_field_1 AND `token_field_2` = :token_field_2 AND `token_field_3` = :token_field_3 AND `token_field_4` = :token_field_4 AND `token_field_5` = :token_field_5";
    
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':token_field_1', $token->getField1());
        $stmt->bindValue(':token_field_2', $token->getField2());
        $stmt->bindValue(':token_field_3', $token->getField3());
        $stmt->bindValue(':token_field_4', $token->getField4());
        $stmt->bindValue(':token_field_5', $token->getChecksumField());
        $stmt->execute();

        $data = $stmt->fetch();

        if (!$data) {
            return null;
        }

        return InvitationToken::fromMySQL($data);
    }

    public function getInvitationTokensFromOwnerUserId(UserId $ownerUserId): InvitationTokens
    {
        $sql = "SELECT * FROM `user_invitation_tokens` WHERE `owner_user_id` = :owner_user_id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':owner_user_id', $ownerUserId->asInt());
        $stmt->execute();

        $data = [];

        while ($row = $stmt->fetch()) {
            $data[] = InvitationToken::fromMySQL($row);
        }

        return InvitationTokens::fromArray(...$data);
    }
}
