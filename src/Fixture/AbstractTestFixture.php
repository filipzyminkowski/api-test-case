<?php

namespace GlobeGroup\ApiTests\Fixture;

use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractTestFixture
{
    /**
     * @var EntityManagerInterface
     */
    protected $manager;

    public function setManager(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    abstract public function load();
}
