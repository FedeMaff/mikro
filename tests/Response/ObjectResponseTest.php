<?php

namespace MikroTest\Response;

use PHPUnit\Framework\TestCase;
use Mikro\Response\ObjectResponse;
use Mikro\Response\Formatter\JsonFormatter;

class ObjectResponseTest extends TestCase
{
    /**
     * Verifica corretta creazione e recupero dati Json
     */
    public function testCreationJson()
    {
        $person = new \StdClass();
        $person->name = 'Federico';
        $person->surname = 'Maffucci';

        $response = new ObjectResponse($person, new JsonFormatter());
        $this->assertEquals('{"name":"Federico","surname":"Maffucci"}', sprintf($response));
    }
}
