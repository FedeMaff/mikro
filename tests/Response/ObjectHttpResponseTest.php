<?php

namespace MikroTest\Response;

use PHPUnit\Framework\TestCase;
use Mikro\Response\ObjectHttpResponse;
use Mikro\Response\Formatter\JsonFormatter;

class ObjectHttpResponseTest extends TestCase
{
    /**
     * Verifica corretta creazione e recupero dati Json
     */
    public function testCreationJson()
    {
        $person = new \StdClass();
        $person->name = 'Federico';
        $person->surname = 'Maffucci';

        $response = new ObjectHttpResponse($person, OK, new JsonFormatter());
        $this->assertEquals('{"name":"Federico","surname":"Maffucci"}', sprintf($response));
        $this->assertEquals(OK, $response->getStatusCode());
        $this->assertEquals(['Content-Type' => 'application/json; charset=utf-8'], $response->getHeaders());
    }
}
