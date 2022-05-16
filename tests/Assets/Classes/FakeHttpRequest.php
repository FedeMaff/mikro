<?php

namespace MikroTest\Assets\Classes;

use Mikro\Request\HttpRequestInterface;

class FakeHttpRequest implements HttpRequestInterface
{
    public function getMethod(): string
    {
        return 'POST';
    }

    public function getPath(): string
    {
        return '/microservizio/v1/customers';
    }

    public function getHeaders(): array
    {
        return [];
    }

    public function getData(): array
    {
        return ['name' => 'Federico', 'cognome' => 'Rossi'];
    }

    public function getFiles(): array
    {
        return [];
    }

    public function getOutputFormat(): string
    {
        return TYPE_JSON;
    }
}
