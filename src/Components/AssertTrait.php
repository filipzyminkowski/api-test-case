<?php

namespace GlobeGroup\ApiTests\Components;


use ArrayAccess;
use Exception;
use GlobeGroup\ApiTests\Assert\ArraySubset;
use PHPUnit\Util\InvalidArgumentHelper;
use function is_array;

trait AssertTrait
{
    public function assertResponseContains(array $expected, bool $fullCheck = false, string $message = ''): self
    {
        $array = $this->decodeResponseJson();

        if (!(is_array($expected) || $expected instanceof ArrayAccess)) {
            throw InvalidArgumentHelper::factory(
                1,
                'array or ArrayAccess'
            );
        }

        if (!(is_array($array) || $array instanceof ArrayAccess)) {
            throw InvalidArgumentHelper::factory(
                2,

                'array or ArrayAccess'
            );
        }

        self::assertTrue(ArraySubset::arrayIntersectRecursive($array, $expected, $fullCheck), $message);

        return $this;
    }

    private function decodeResponseJson($key = null)
    {
        $decodedResponse = json_decode($this->response->getContent(), true);
        if ($decodedResponse === null || $decodedResponse === false) {
            throw new Exception('Response is not a valid JSON.');
        }
        return $decodedResponse[$key] ?? $decodedResponse;
    }
}
