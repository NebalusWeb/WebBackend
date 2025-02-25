<?php

namespace Nebalus\Webapi\Api;

use Nebalus\Sanitizr\Schema\SanitizrObjectSchema;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Exception\ApiInvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractValidator
{
    public const int MAX_RECURSION = 100;

    protected function __construct(private readonly SanitizrObjectSchema $validationSchema)
    {
    }

    /**
     * @throws ApiException
     */
    public function validate(ServerRequestInterface $request, array $rawPathArgs = []): void
    {
        $validData = $this->validationSchema->safeParse([
            RequestParamTypes::BODY => json_decode($request->getBody()->getContents(), true, self::MAX_RECURSION) ?? [],
            RequestParamTypes::QUERY_PARAMS => $request->getQueryParams() ?? [],
            RequestParamTypes::PATH_ARGS => $rawPathArgs,
        ]);

        if ($validData->isError()) {
            throw new ApiInvalidArgumentException($validData->getErrorMessage());
        }

        $this->onValidate($validData->getValue()[RequestParamTypes::BODY] ?? [], $validData->getValue()[RequestParamTypes::QUERY_PARAMS] ?? [], $validData->getValue()[RequestParamTypes::PATH_ARGS] ?? []);
    }

    /**
     * @throws ApiException
     */
    abstract protected function onValidate(array $bodyData, array $queryParamsData, array $pathArgsData): void;
}
