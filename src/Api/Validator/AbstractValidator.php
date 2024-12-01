<?php

namespace Nebalus\Webapi\Api\Validator;

use JsonException;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Exception\ApiInvalidArgumentException;
use Nebalus\Webapi\Exception\ApiValidationException;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractValidator
{
    private array $rules;

    protected function __construct(array $rules = [])
    {
        $this->rules = $rules;
    }

    /**
     * @throws ApiException
     */
    public function validate(ServerRequestInterface $request): void
    {
        try {
            $data = json_decode($request->getBody()->getContents(), true, 5, JSON_THROW_ON_ERROR);
        } catch (JsonException) {
            throw new ApiValidationException(
                'Invalid JSON request',
                400
            );
        }

        $filteredData = $this->processRecursiveRules($data, $this->rules, 5);
//        echo json_encode($filteredData, JSON_PRETTY_PRINT, 5) . "\n\n";
        $this->onValidate($filteredData);
    }

    /**
     * @throws ApiException
     */
    private function processRecursiveRules(array $dataLayer, array $ruleLayer, int $maxRecursion, int $layerId = 0, string $path = ''): array
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
            $type = strtolower($rule['type'] ?? "string"); // Todo: String entfernen
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
                if ($type === 'string' && is_string($value) === true) {
                    $processedData[$param] = $value;
                    continue;
                } elseif ($type === 'integer' && is_int($value) === true) {
                    $processedData[$param] = $value;
                    continue;
                } elseif ($type === 'float' && is_float($value) === true) {
                    $processedData[$param] = $value;
                    continue;
                } elseif ($type === 'boolean' && is_bool($value) === true) {
                    $processedData[$param] = $value;
                    continue;
                } elseif ($type === 'object' && is_array($value) && empty($value) === false) {
                    if ($childrenRules !== []) {
                        $processedData[$param] = $this->processRecursiveRules($value, $childrenRules, $maxRecursion, $layerId, $currentPath . ".");
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
    abstract protected function onValidate(array $filteredData): void;
}
