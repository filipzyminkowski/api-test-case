<?php

namespace GlobeGroup\ApiTests\Exception;

use Exception;
use GlobeGroup\ApiTests\Assert\AbstractTestFixture;

class BadFixtureCallException extends Exception
{
    public function __construct(string $classname)
    {
        parent::__construct('Fixture "' . $classname . '" has to be instance of "' . AbstractTestFixture::class . '.');
    }
}
