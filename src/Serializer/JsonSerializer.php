<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Enbit\Dhl\Retoure\Serializer;

/**
 * JsonSerializer
 *
 * Serializer for outgoing request types and incoming responses.
 *
 * @author Max Melzer <max.melzer@netresearch.de>
 * @link   https://www.enbit.de/
 */
class JsonSerializer
{
    public function encode(\JsonSerializable $request): string
    {
        // remove empty entries from serialized data (after all objects were converted to array)
        $payload = (string) \json_encode($request);
        $payload = (array) \json_decode($payload, true);
        $payload = $this->filterRecursive($payload);

        return (string) \json_encode($payload);
    }

    public function toArray(\JsonSerializable $request): array
    {
        // remove empty entries from serialized data (after all objects were converted to array)
        $payload = (string) \json_encode($request);
        $payload = (array) \json_decode($payload, true);
        return $this->filterRecursive($payload);
    }

    /**
     * Recursively filter null and empty strings from the given (nested) array
     *
     * @param mixed[] $element
     * @return mixed[]
     */
    private function filterRecursive(array $element): array
    {
        // Filter null and empty strings
        $filterFunction = static function ($entry): bool {
            return ($entry !== null) && ($entry !== '') && ($entry !== []);
        };

        foreach ($element as &$value) {
            if (\is_array($value)) {
                $value = $this->filterRecursive($value);
            }
        }

        return array_filter($element, $filterFunction);
    }

    /**
     * @param string $jsonResponse
     * @return string[]
     */
    public function decode(string $jsonResponse): array
    {
        return \json_decode($jsonResponse, true);
    }
}
