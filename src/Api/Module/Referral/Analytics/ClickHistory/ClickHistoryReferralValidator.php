<?php

namespace Nebalus\Webapi\Api\Module\Referral\Analytics\ClickHistory;

use Nebalus\Sanitizr\Sanitizr as S;
use Nebalus\Webapi\Api\AbstractValidator;
use Nebalus\Webapi\Config\Types\RequestParamTypes;
use Nebalus\Webapi\Value\Module\Referral\ReferralCode;
use Nebalus\Webapi\Value\User\UserId;

class ClickHistoryReferralValidator extends AbstractValidator
{
    private ReferralCode $referralCode;
    private ?UserId $userId;
    private int $range;

    public function __construct()
    {
        parent::__construct(S::object([
            RequestParamTypes::PATH_ARGS => S::object([
                'code' => ReferralCode::getSchema(),
                "userId" => S::string()->equals("self")->or(UserId::getSchema()),
            ]),
            RequestParamTypes::QUERY_PARAMS => S::object([
                'range' => S::number()->integer()->positive()
            ]),
        ]));
    }

    protected function onValidate(array $bodyData, array $queryParamsData, array $pathArgsData): void
    {
        $this->referralCode = ReferralCode::from($pathArgsData['code']);
        $this->userId = isset($pathArgsData["userId"]) && $pathArgsData["userId"] === "self" ? null : UserId::from($pathArgsData["userId"]);
        $this->range = $queryParamsData['range'];
    }

    public function getReferralCode(): ReferralCode
    {
        return $this->referralCode;
    }

    public function getUserId(): ?UserId
    {
        return $this->userId;
    }

    public function getRange(): int
    {
        return $this->range;
    }
}
