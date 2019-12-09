<?php

namespace GlobeGroup\ApiTests\Factory;

use GlobeGroup\ApiTests\Exception\BadFixtureCallException;
use Faker;
use Doctrine\ORM\EntityManagerInterface;

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

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
        $generator = Faker\Factory::create();
        $this->populator = new Faker\ORM\Doctrine\Populator($generator, $this->manager);
    }

    /**
     * @param string $entityClassName
     * @param int $amount
     *
     * @throws BadFixtureCallException
     */
    public function defineCreation(string $entityClassName,int $amount = 1)
    {
        if (!class_exists($entityClassName)) {
            throw new BadFixtureCallException($entityClassName);
        }

        if ($amount < 1) {
            throw new \BadMethodCallException('Amount has to be 1 or greater.');
        }

        $this->entityClassName = $entityClassName;
        $this->amount = $amount;
    }

    public function create(array $fields = [])
    {
        $this->populator->addEntity($this->entityClassName,$this->amount);

        if ($this->amount === 1) {
            $result = $this->populator->execute($this->manager);
            return reset($result);
        }

        return $this->populator->execute($this->manager);
    }
}