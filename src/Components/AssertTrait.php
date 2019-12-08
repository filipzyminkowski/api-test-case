<?php

namespace GlobeGroup\ApiTests\Components;

use ArrayAccess;
use Exception;
use GlobeGroup\ApiTests\Assert\ArraySubset;
use PHPUnit\Util\InvalidArgumentHelper;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpFoundation\Response;


/**
 * @property KernelBrowser client
 * @property Response response
 */
trait AssertTrait
{
    public function assertResponseContains(array $expected, bool $fullCheck = true, string $message = ''): self
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

        $result = ArraySubset::arrayIntersectRecursive($array, $expected, $fullCheck);

        if (!$result) {
            self::assertSame($expected, $array);
            self::assertTrue($result);
        } else {
            self::assertTrue($result, $message);
        }

        return $this;
    }

    private function decodeResponseJson($key = null)
    {
        $decodedResponse = json_decode($this->getResponseObject()->getContent(false), true);
        if ($decodedResponse === null || $decodedResponse === false) {
            throw new Exception('Response is not a valid JSON.' . $this->getResponseObject()->getContent(false));
        }
        return $decodedResponse[$key] ?? $decodedResponse;
    }

    public function assertHttpStatus(int $statusCode): self
    {
        self::assertSame($statusCode, (int)$this->getResponseObject()->getStatusCode());

        return $this;
    }
}
