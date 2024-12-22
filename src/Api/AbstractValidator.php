<?php

namespace Nebalus\Webapi\Api;

use JsonException;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Exception\ApiInvalidArgumentException;
use Nebalus\Webapi\Exception\ApiValidationException;
use Nebalus\Webapi\Value\Internal\Validation\ValidatedData;
use Nebalus\Webapi\Value\Internal\Validation\ValidType;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractValidator
{
    private const int MAX_RECURSION = 5;

    protected function __construct(private readonly array $rules = [])
    {
    }

    /**
     * @throws ApiException
     */
    public function validate(ServerRequestInterface $request, array $pathArgs): void
    {
        $validData = ValidatedData::create();

        if (isset($this->rules['body'])) {
            try {
                $bodyData = json_decode($request->getBody()->getContents(), true, self::MAX_RECURSION, JSON_THROW_ON_ERROR);
                $validData = $validData->setBodyData($this->validateJsonSchema($bodyData, $this->rules['body'], self::MAX_RECURSION));
            } catch (JsonException) {
                throw new ApiValidationException(
                    'Invalid JSON request',
                    400
                );
            }
        }

        if (isset($this->rules['query_param'])) {
            $queryParamData = $request->getQueryParams() ?? [];
            $validData = $validData->setQueryParamsData($this->validateJsonSchema($queryParamData, $this->rules['query_param'], self::MAX_RECURSION));
        }

        if (isset($this->rules['path_args'])) {
            $validData = $validData->setPathArgsData($this->validateJsonSchema($pathArgs, $this->rules['path_args'], self::MAX_RECURSION));
        }

        $this->onValidate($validData);
    }

    /**
     * @throws ApiException
     */
    private function validateJsonSchema(array $dataLayer, array $ruleLayer, int $maxRecursion, int $layerId = 0, string $path = ''): array
    {
        $processedData = [];
        $layerId++;
        if ($layerId > $maxRecursion) {
            return $processedData;
        }

        foreach ($ruleLayer as $param => $rule) {
            $currentPath = $path . $param;
            $isKeyExisting = key_exists($param, $dataLayer);
            $isRequired = $rule['required'] ?? false;
            $isNullable = $rule['nullable'] ?? false;
            $defaultValue = $rule['default'] ?? null;
            $type = $rule['type'] ?? ValidType::STRING; // Todo: String entfernen
            $childrenRules = $rule['children'] ?? [];
//            echo("----------------------------------- \n");
//            echo("LayerID: \n");
//            var_dump($layerId);
//            echo("CurrentPath: \n");
//            var_dump($currentPath);
//            echo("IsKeyExisting: \n");
//            var_dump($isKeyExisting);
//            echo("IsRequired: \n");
//            var_dump($isRequired);
//            echo("IsNullable: \n");
//            var_dump($isNullable);
//            echo("DefaultValue: \n");
//            var_dump($defaultValue);
//            echo("Datatype: \n");
//            var_dump($datatype);

            if ($isRequired && $isKeyExisting === false) {
                throw new ApiInvalidArgumentException(
                    "Parameter '{$currentPath}' is required in the JSON request",
                    400
                );
            }

            $value = $dataLayer[$param] ?? $defaultValue;
//
//            echo("Pre Value: \n");
//            var_dump($value);

            if ($defaultValue !== null) {
                if (
                    $isRequired === true && $isNullable === true && $value === null ||
                    $isRequired === false && $isKeyExisting === false ||
                    $isRequired === false && $isKeyExisting === true && $isNullable === true && $value === null
                ) {
                    $value = $defaultValue;
                }
            }
//
//            echo("Final Value: \n");
//            var_dump($value);
//            echo(" \n");

            if ($isNullable === false && is_null($value)) {
                throw new ApiInvalidArgumentException(
                    "Parameter '{$currentPath}' cannot be null",
                    400
                );
            }

            if ($value !== null) {
                if ($type == ValidType::STRING && is_string($value) === true) {
                    $processedData[$param] = $value;
                    continue;
                } elseif ($type == ValidType::INTEGER && is_int($value) === true) {
                    $processedData[$param] = $value;
                    continue;
                } elseif ($type == ValidType::FLOAT && is_float($value) === true) {
                    $processedData[$param] = $value;
                    continue;
                } elseif ($type == ValidType::BOOLEAN && is_bool($value) === true) {
                    $processedData[$param] = $value;
                    continue;
                } elseif ($type == ValidType::OBJECT && is_array($value) && empty($value) === false) {
                    if ($childrenRules !== []) {
                        $processedData[$param] = $this->validateJsonSchema($value, $childrenRules, $maxRecursion, $layerId, $currentPath . ".");
                    }
                    continue;
                }

                throw new ApiInvalidArgumentException(
                    "Parameter '{$currentPath}' must to an $type",
                    400
                );
            }
            $processedData[$param] = $value;
        }
        return $processedData;
    }

    /**
     * @throws ApiException
     */
    abstract protected function onValidate(ValidatedData $validatedData): void;
}
