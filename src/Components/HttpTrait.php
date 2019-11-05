<?php

namespace GlobeGroup\ApiTests\Components;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\ResponseInterface;

trait HttpTrait
{
    public function jsonGet(string $route, array $query, array $options = []): self
    {
        $options = array_merge($options , $query);

        if ($this->authorization !== null) {
            $options = array_merge($options, ['headers' => $this->authorization]);
        }

        $this->start();

        $this->client->request(Request::METHOD_GET, $route, $options);
        $this->getResponseObject();

        $this->stop();

        return $this;
    }

    public function jsonPost(string $route, array $body, array $options = []): self
    {
        $options = array_merge($options , $body);

        if ($this->authorization !== null) {
            $options = array_merge($options, ['headers' => $this->authorization]);
        }

        $this->start();

        $this->client->request(Request::METHOD_POST, $route, $options);
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

    public function jsonDelete(string $route, array $query, array $options = []): self
    {
        $options = array_merge($options , $query);

        if ($this->authorization !== null) {
            $options = array_merge($options, ['headers' => $this->authorization]);
        }

        $this->start();

        $this->client->request(Request::METHOD_DELETE, $route, $options);
        $this->getResponseObject();

        $this->stop();

        return $this;
    }

    public function jsonPatch(string $route, array $body, array $options = []): self
    {
        $options = array_merge($options , $body);

        if ($this->authorization !== null) {
            $options = array_merge($options, ['headers' => $this->authorization]);
        }

        $this->start();

        $this->client->request(Request::METHOD_PATCH, $route, $options);
        $this->getResponseObject();

        $this->stop();

        return $this->response;
    }

    private function createJsonClient()
    {
        return static::createClient([
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);
    }
}
