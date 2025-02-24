<?php

namespace Nebalus\Webapi\Api\Module\Referral\Edit;

use Nebalus\Sanitizr\Sanitizr as S;
use Nebalus\Webapi\Api\AbstractValidator;
use Nebalus\Webapi\Value\Internal\Validation\ValidRequestData;
use Nebalus\Webapi\Value\Module\Referral\ReferralCode;
use Nebalus\Webapi\Value\Url;

class EditReferralValidator extends AbstractValidator
{
    private ReferralCode $referralCode;
    private Url $url;
    private bool $disabled;

    public function __construct()
    {
        parent::__construct(S::object([
            "path_args" => S::object([
                'code' => S::string()->length(ReferralCode::LENGTH)->regex(ReferralCode::REGEX)
            ]),
            "body" => S::object([
                'url' => S::string()->optional()->nullable()->url(),
                'disabled' => S::boolean()->optional()->default(false),
            ])
        ]));
    }

    protected function onValidate(ValidRequestData $request): void
    {
        $this->referralCode = ReferralCode::from($request->getPathArgsData()['code']);
        $this->url = Url::from($request->getBodyData()['url']);
        $this->disabled = $request->getBodyData()['disabled'];
    }

    public function getReferralCode(): ReferralCode
    {
        return $this->referralCode;
    }

    public function getUrl(): Url
    {
        return $this->url;
    }

    public function isDisabled(): bool
    {
        return $this->disabled;
    }
}
