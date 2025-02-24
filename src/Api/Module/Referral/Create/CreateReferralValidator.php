<?php

namespace Nebalus\Webapi\Api\Module\Referral\Create;

use Nebalus\Sanitizr\Sanitizr as S;
use Nebalus\Webapi\Api\AbstractValidator;
use Nebalus\Webapi\Value\Internal\Validation\ValidRequestData;
use Nebalus\Webapi\Value\Module\Referral\ReferralName;
use Nebalus\Webapi\Value\Url;

class CreateReferralValidator extends AbstractValidator
{
    private ReferralName $referralName;
    private Url $url;
    private bool $disabled;

    public function __construct()
    {
        parent::__construct(S::object([
            "body" => S::object([
                'name' => S::string(),
                'url' => S::string()->url(),
                'disabled' => S::boolean()->optional()->default(false),
            ])
        ]));
    }

    protected function onValidate(ValidRequestData $request): void
    {
        $this->referralName = ReferralName::from($request->getBodyData()['name']);
        $this->url = Url::from($request->getBodyData()['url']);
        $this->disabled = $request->getBodyData()['disabled'];
    }

    public function getReferralName(): ReferralName
    {
        return $this->referralName;
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
