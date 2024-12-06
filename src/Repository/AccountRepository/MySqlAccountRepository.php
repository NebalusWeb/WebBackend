<?php

namespace Nebalus\Webapi\Repository\AccountRepository;

use Nebalus\Webapi\Exception\ApiDatabaseException;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Value\ID;
use Nebalus\Webapi\Value\User\InvitationToken\InvitationToken;
use Nebalus\Webapi\Value\User\InvitationToken\InvitationTokens;
use Nebalus\Webapi\Value\User\InvitationToken\PureInvitationToken;
use PDO;
use PDOException;

class MySqlAccountRepository
{
    public function __construct(
        private PDO $pdo
    ) {
    }

    /**
     * @throws ApiException
     */
    public function updateInvitationToken(InvitationToken $invitationToken): void
    {
        try {
            $sql = "
                UPDATE `account_invitation_tokens` 
                SET `invited_account_id`=:invited_account_id,`used_at`=:used_at 
                WHERE `token_field_1` = :token_field_1 AND `token_field_2` = :token_field_2 AND `token_field_3` = :token_field_3 AND `token_field_4` = :token_field_4 AND `token_checksum` = :token_checksum
                ";

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':invited_account_id', $invitationToken->getInvitedUserId()->asInt());
            $stmt->bindValue(':used_at', $invitationToken->getUsedAtDate()->format('Y-m-d H:i:s'));
            $stmt->bindValue(':token_field_1', $invitationToken->getField1()->asInt());
            $stmt->bindValue(':token_field_2', $invitationToken->getField2()->asInt());
            $stmt->bindValue(':token_field_3', $invitationToken->getField3()->asInt());
            $stmt->bindValue(':token_field_4', $invitationToken->getField4()->asInt());
            $stmt->bindValue(':token_checksum', $invitationToken->getChecksumField()->asInt());
            $stmt->execute();
        } catch (PDOException $e) {
            throw new ApiDatabaseException(
                "Failed to edit the Invitation Token",
                500,
                $e
            );
        }
    }

    /**
     * @throws ApiException
     */
    public function findInvitationTokenByFields(PureInvitationToken $token): ?InvitationToken
    {
        try {
            $sql = "SELECT * FROM account_invitation_tokens WHERE token_field_1 = :token_field_1 AND token_field_2 = :token_field_2 AND token_field_3 = :token_field_3 AND token_field_4 = :token_field_4 AND token_checksum = :token_checksum";

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':token_field_1', $token->getField1()->asInt());
            $stmt->bindValue(':token_field_2', $token->getField2()->asInt());
            $stmt->bindValue(':token_field_3', $token->getField3()->asInt());
            $stmt->bindValue(':token_field_4', $token->getField4()->asInt());
            $stmt->bindValue(':token_checksum', $token->getChecksumField()->asInt());
            $stmt->execute();

            $data = $stmt->fetch();

            if (!$data) {
                return null;
            }

            return InvitationToken::fromDatabase($data);
        } catch (PDOException $e) {
            throw new ApiDatabaseException(
                "Failed to edit the Invitation Token",
                500,
                $e
            );
        }
    }

    public function getInvitationTokensFromOwnerUserId(ID $ownerUserId): InvitationTokens
    {
        $data = [];
        try {
            $sql = "SELECT * FROM `account_invitation_tokens` WHERE `owner_account_id` = :owner_account_id";

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':owner_account_id', $ownerUserId->asInt());
            $stmt->execute();

            while ($row = $stmt->fetch()) {
                $data[] = InvitationToken::fromArray($row);
            }
        } catch (PDOException | ApiException) {
        }
        return InvitationTokens::fromArray(...$data);
    }
}
