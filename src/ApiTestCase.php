<?php

namespace GlobeGroup\ApiTests;

use GlobeGroup\ApiTests\Components\AssertTrait;
use GlobeGroup\ApiTests\Components\DebugTrait;
use GlobeGroup\ApiTests\Components\FixturesTrait;
use GlobeGroup\ApiTests\Components\HttpTrait;
use GlobeGroup\ApiTests\Components\SecurityTrait;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

abstract class ApiTestCase extends WebTestCase
{
    use RefreshDatabaseTrait, AssertTrait, HttpTrait, FixturesTrait,
        SecurityTrait, DebugTrait;

    /**
     * @var KernelInterface
     */
    protected static $kernel;

    /**
     * @var KernelBrowser
     */
    private $client;

    /**
     * @var ResponseInterface
     */
    private $response;

    /**
     * @var array
     */
    private $authorization;

    /** @var bool */
    private $doMeasurement;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        self::$purgeWithTruncate = true;
        self::$append = false;
    }

    public function getContainer(): ContainerInterface
    {
        return self::$container;
    }

    protected function setUp()
    {
        parent::setUp();

        self::$kernel = self::bootKernel();

        $this->client = $this->createJsonClient();
        $this->authorization = null;
        $this->doMeasurement = false;
    }

    protected function tearDown()
    {
        parent::tearDown();
        $this->clearDatabase();
    }
}
