<?php

namespace MikroTest\Assets\Classes;

use Mikro\Controller\HttpController;
use Mikro\Response\ResponseInterface;

class FakeHttpControllerWithPathVariables extends HttpController
{
    private ?int $id = null;
    private ?string $day = null;

    protected static string $method = 'GET';
    protected static string $path = '/microservizio/v1/utenti/{id}/giornate/{day:string}';

    public function __construct(int $id, string $day)
    {
        $this->id = $id;
        $this->day = $day;
    }

    public function run(): ?ResponseInterface
    {
        $string = sprintf('Ciao l\'id utente è %s, mentre il girno è %s', $this->id, $this->day);
        return $this->toResponse($string);
    }
}
