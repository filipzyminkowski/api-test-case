<?php

namespace GlobeGroup\ApiTests\Components;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @property KernelBrowser client
 * @property Response response
 */
trait HttpTrait
{
    public function jsonGet(string $route, array $query = [], array $options = []): self
    {
        if ($this->authorization !== null) {
            $options = array_merge($options, $this->authorization);
        }

        $this->start();

        $this->client->request(Request::METHOD_GET, $route, $query, [], $options);
        $this->getResponseObject();

        $this->stop();

        return $this;
    }

    public function jsonPost(string $route, array $body = [], array $options = []): self
    {
        if ($this->authorization !== null) {
            $options = array_merge($options, $this->authorization);
        }

        $this->start();

        $this->client->request(Request::METHOD_POST, $route, $body, [], $options);
        $this->getResponseObject();

        $this->stop();

        return $this;
    }

    public function getResponseObject(): Response
    {
        if ($this->response === null) {
            $this->response = $this->client->getResponse();
        }

        return $this->response;
    }

    public function jsonDelete(string $route, array $query = [], array $options = []): self
    {
        if ($this->authorization !== null) {
            $options = array_merge($options, $this->authorization);
        }

        $this->start();

        $this->client->request(Request::METHOD_DELETE, $route, $query, [], $options);
        $this->getResponseObject();

        $this->stop();

        return $this;
    }

    public function jsonPatch(string $route, array $body, array $options = []): self
    {
        if ($this->authorization !== null) {
            $options = array_merge($options, $this->authorization);
        }

        $this->start();

        $this->client->request(Request::METHOD_PATCH, $route, $body, [], $options);
        $this->getResponseObject();

        $this->stop();

        return $this;
    }

    private function createJsonClient()
    {
        return static::createClient([], [
            'HTTP_ACCEPT' => 'application/json',
            'HTTP_CONTENT-TYPE' => 'application/json',
        ]);
    }
}
