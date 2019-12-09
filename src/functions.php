<?php

use GlobeGroup\ApiTests\ApiTestCase;
use GlobeGroup\ApiTests\Factory\FactoryInterface;

if (!function_exists('factory')) {
    function factory(string $entityClassname, int $amount = 1): FactoryInterface
    {
        return ApiTestCase::factory($entityClassname, $amount);
    }
}