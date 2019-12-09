<?php

namespace GlobeGroup\ApiTests\Components;

use GlobeGroup\ApiTests\Factory\EntityFactory;
use GlobeGroup\ApiTests\Factory\FactoryInterface;

trait FixturesTrait
{
    public static function factory(string $entityClassname, int $i = 1): FactoryInterface
    {
        $container = self::$kernel->getContainer();
        
        /** @var EntityFactory $factory */
        $factory = $container->get('test.factory.entity_factory');
        $factory->defineCreation($entityClassname, $i);

        return $factory;
    }
}
