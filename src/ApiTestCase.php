<?php

namespace GlobeGroup\ApiTests;

use GlobeGroup\ApiTests\Components\AssertTrait;
use GlobeGroup\ApiTests\Components\DebugTrait;
use GlobeGroup\ApiTests\Components\FixturesTrait;
use GlobeGroup\ApiTests\Components\HttpTrait;
use GlobeGroup\ApiTests\Components\SecurityTrait;
use Hautelook\AliceBundle\PhpUnit\RecreateDatabaseTrait;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * Class ApiTestCase
 */
abstract class ApiTestCase extends KernelTestCase
{
    use ReloadDatabaseTrait, AssertTrait, HttpTrait, FixturesTrait,
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

    public function getContainer(): ContainerInterface
    {
        return self::$container;
    }

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        self::$purgeWithTruncate = true;
        self::$append = false;
    }

    protected function setUp()
    {
        parent::setUp();

        self::$kernel = self::bootKernel();

        $this->client = $this->createJsonClient();
        $this->authorization = null;
    }

    protected function tearDown()
    {
        parent::tearDown();
    }
}
