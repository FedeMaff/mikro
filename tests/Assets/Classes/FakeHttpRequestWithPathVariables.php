<?php

namespace MikroTest\Assets\Classes;

use Mikro\Request\HttpRequestInterface;

class FakeHttpRequestWithPathVariables implements HttpRequestInterface
{
    public function getMethod(): string
    {
        return 'GET';
    }

    public function getPath(): string
    {
        return '/microservizio/v1/utenti/12/giornate/martedi-28-dicembre-2021';
    }

    public function getHeaders(): array
    {
        return [];
    }

    public function getData(): array
    {
        return ['parametro1' => 'ciao', 'parametro2' => 100];
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
