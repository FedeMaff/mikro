<?php

namespace MikroTest\Response;

use PHPUnit\Framework\TestCase;
use MikroTest\Assets\Classes\FakeEntityUser;
use Mikro\Response\EntityResponse;
use Mikro\Response\Formatter\JsonFormatter;
use Mikro\Settings;

class EntityResponseTest extends TestCase
{
    /**
     * Verifica corretta creazione e recupero dati Json
     */
    public function testCreationJson()
    {
        $person = new FakeEntityUser(12, 'Federico', 'Maffucci', 123);

        $response = new EntityResponse($person, new JsonFormatter());
        $this->assertEquals('{"id":12,"name":"Federico","surname":"Maffucci","n":123}', sprintf($response));
    }

    /**
     * Verifica corretta creazione e recupero dati Json con Hateoas
     */
    public function testCreationJsonWithHateoas()
    {
        Settings::addHateoasYamlDirPath(__DIR__ . '/yaml', 'MikroTest\Assets\Classes');
        $person = new FakeEntityUser(24, 'Federico', 'Maffucci', 12);

        $response = new EntityResponse($person, new JsonFormatter());
        $this->assertEquals('{"fullname":"Federico Maffucci","_links":{"self":{"href":"\/fakeusers\/24"}}}', sprintf($response));
        Settings::resetHateoasYamlDirsPaths();
    }
}
