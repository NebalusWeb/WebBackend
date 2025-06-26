<?php

namespace Nebalus\Webapi\Api\Module\Referral\Analytics\ClickHistory;

use Nebalus\Sanitizr\Sanitizr as S;
use Nebalus\Webapi\Api\AbstractValidator;
use Nebalus\Webapi\Config\Types\RequestParamTypes;
use Nebalus\Webapi\Value\Module\Referral\ReferralCode;

class ClickHistoryReferralValidator extends AbstractValidator
{
    private ReferralCode $referralCode;
    private int $range;

    public function __construct()
    {
        parent::__construct(S::object([
            RequestParamTypes::PATH_ARGS => S::object([
                'code' => ReferralCode::getSchema()
            ]),
            RequestParamTypes::QUERY_PARAMS => S::object([
                'range' => S::number()->integer()->positive()
            ])
        ]));
    }

    protected function onValidate(array $bodyData, array $queryParamsData, array $pathArgsData): void
    {
        $this->referralCode = ReferralCode::from($pathArgsData['code']);
        $this->range = $queryParamsData['range'];
    }

    public function getReferralCode(): ReferralCode
    {
        return $this->referralCode;
    }

    public function getRange(): int
    {
        return $this->range;
    }
}
