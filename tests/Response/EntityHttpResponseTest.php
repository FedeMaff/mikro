<?php

namespace MikroTest\Response;

use PHPUnit\Framework\TestCase;
use MikroTest\Assets\Classes\FakeEntityUser;
use Mikro\Response\EntityHttpResponse;
use Mikro\Response\Formatter\JsonFormatter;

class EntityHttpResponseTest extends TestCase
{
    /**
     * Verifica corretta creazione e recupero dati Json
     */
    public function testCreationJson()
    {
        $person = new FakeEntityUser(12, 'Federico', 'Maffucci');

        $response = new EntityHttpResponse($person, OK, new JsonFormatter());
        $this->assertEquals('{"id":12,"name":"Federico","surname":"Maffucci","n":0}', sprintf($response));
        $this->assertEquals(OK, $response->getStatusCode());
        $this->assertEquals(['Content-Type' => 'application/json; charset=utf-8'], $response->getHeaders());
    }
}
