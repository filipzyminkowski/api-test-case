<?php

namespace GlobeGroup\ApiTests\Components;

use GlobeGroup\ApiTests\ApiTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * Trait HttpTrait
 * @property KernelBrowser client
 * @package GlobeGroup\ApiTests\Components
 */
trait HttpTrait
{
    public function jsonGet(string $route, array $query, array $options = []): ApiTestCase
    {
        $options['query'] = $query;

        if ($this->authorization !== null) {
            $options = array_merge($options, ['headers' => $this->authorization]);
        }

        $this->response = $this->client->request(Request::METHOD_GET, $route, $options);

        return $this;
    }

    public function assertHttpStatus(int $statusCode)
    {
        self::assertSame($statusCode, (int)$this->response->getStatusCode());
        return $this;
    }

    public function jsonPost(string $route, array $body, array $options = []): ResponseInterface
    {
        $options['body'] = $body;

        if ($this->authorization !== null) {
            $options = array_merge($options, ['headers' => $this->authorization]);
        }

        $this->response = $this->client->request(Request::METHOD_POST, $route, $options);

        return $this->response;
    }

    public function jsonDelete(string $route, array $query, array $options = []): ResponseInterface
    {
        $options['query'] = $query;

        if ($this->authorization !== null) {
            $options = array_merge($options, ['headers' => $this->authorization]);
        }

        $this->response = $this->client->request(Request::METHOD_DELETE, $route, $options);

        return $this->response;
    }

    public function jsonPatch(string $route, array $body, array $options = []): ResponseInterface
    {
        $options['body'] = $body;

        if ($this->authorization !== null) {
            $options = array_merge($options, ['headers' => $this->authorization]);
        }

        $this->response = $this->client->request(Request::METHOD_PATCH, $route, $options);

        return $this->response;
    }

    private function createJsonClient()
    {
        return HttpClient::create([
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);
    }
}
