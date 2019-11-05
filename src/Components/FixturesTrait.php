<?php

namespace GlobeGroup\ApiTests\Components;

use Doctrine\ORM\EntityManager;
use GlobeGroup\ApiTests\Exception\BadFixtureCallException;
use GlobeGroup\ApiTests\Fixture\AbstractTestFixture;
use Psr\Container\ContainerInterface;

trait FixturesTrait
{
    public function loadFixture(string $classname)
    {
        /** @var ContainerInterface $container */
        $container = self::$kernel->getContainer();


        if (!in_array(AbstractTestFixture::class, class_parents($classname), true)) {
            throw new BadFixtureCallException($classname);
        }

        $manager = $container->get('doctrine.orm.entity_manager');
        $manager->getConnection()->getConfiguration()->setSQLLogger(null);

        $fixture = $container->get($classname);
        $fixture->load();
    }

    public function clearDatabase()
    {
        /** @var ContainerInterface $container */
        $container = self::$kernel->getContainer();
        /** @var EntityManager $entityManager */
        $entityManager->getConnection()->getConfiguration()->setSQLLogger(null);

        $entityManager->getConnection()->prepare('SET FOREIGN_KEY_CHECKS = 0;')->execute();

        foreach ($entityManager->getConnection()->getSchemaManager()->listTableNames() as $tableNames) {
            $sql = 'TRUNCATE TABLE ' . $tableNames . ';';
            $entityManager->getConnection()->prepare($sql)->execute();
        }
        $entityManager->getConnection()->prepare('SET FOREIGN_KEY_CHECKS = 1;')->execute();
    }
}
