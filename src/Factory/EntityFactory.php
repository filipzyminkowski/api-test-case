<?php

namespace GlobeGroup\ApiTests\Factory;

use BadMethodCallException;
use Doctrine\ORM\EntityManagerInterface;
use Faker;
use GlobeGroup\ApiTests\Exception\BadFixtureCallException;

class EntityFactory implements FactoryInterface
{
    /** @var string */
    protected $entityClassName;

    /** @var int */
    protected $amount;

    /** @var EntityManagerInterface */
    protected $manager;

    /** @var Faker\ORM\Doctrine\Populator */
    protected $populator;

    /** @var string */
    protected $rootDir;

    /** @var array */
    protected $definitions;

    /** @var Faker\Generator */
    protected $generator;

    public function __construct(EntityManagerInterface $manager, string $rootDir)
    {
        $this->manager = $manager;
        $this->rootDir = $rootDir;
        $this->generator = Faker\Factory::create();
        $this->populator = new Faker\ORM\Doctrine\Populator($this->generator, $this->manager);
    }

    public function defineCreation(string $entityClassName, int $amount = 1): void
    {
        if (!class_exists($entityClassName)) {
            throw new BadFixtureCallException($entityClassName);
        }

        if ($amount < 1) {
            throw new BadMethodCallException('Amount has to be 1 or greater.');
        }

        $this->entityClassName = $entityClassName;
        $this->amount = $amount;
    }

    public function create(array $fields = [])
    {
        $this->populator->addEntity(
            $this->entityClassName,
            $this->amount,
            $this->getDefintion(),
            $fields
        );

        if ($this->amount === 1) {
            $result = $this->populator->execute($this->manager);
            return reset($result);
        }

        return $this->populator->execute($this->manager);
    }

    protected function getDefintion(): array
    {
        if ($this->definitions === null) {
            /**
             * @var Faker\Generator $faker
             * Created for accessing $faker variable from config/faker/faker.php
             */
            $faker = $this->generator;
            $this->definitions = require $this->rootDir . '/config/faker/faker.php';
        }

        if (array_key_exists($this->entityClassName, $this->definitions)) {
            return $this->definitions[$this->entityClassName];
        }

        return [];
    }
}