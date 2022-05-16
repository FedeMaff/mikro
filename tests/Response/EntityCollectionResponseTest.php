<?php

namespace MikroTest\Response;

use PHPUnit\Framework\TestCase;
use MikroTest\Assets\Classes\FakeEntityUser;
use Mikro\Response\EntityCollectionResponse;
use Mikro\Response\Formatter\JsonFormatter;
use Mikro\EntityCollection\EntityCollection;
use Mikro\Settings;

class EntityCollectionResponseTest extends TestCase
{
    /**
     * Verifica corretta creazione e recupero dati Json
     */
    public function testCreationJson()
    {
        $users[] = new FakeEntityUser(1, 'Federico', 'Maffucci');
        $users[] = new FakeEntityUser(2, 'Lorenzo', 'Maffucci');
        $users[] = new FakeEntityUser(3, 'Edoardo', 'Maffucci');
        $users[] = new FakeEntityUser(4, 'Alessandro', 'Maffucci');
        $users[] = new FakeEntityUser(5, 'Alessio', 'Maffucci');
        $users[] = new FakeEntityUser(6, 'Manuele', 'Maffucci');
        $users[] = new FakeEntityUser(7, 'Mattia', 'Maffucci');
        $users[] = new FakeEntityUser(8, 'Francesco', 'Maffucci');
        $users[] = new FakeEntityUser(9, 'Stefano', 'Maffucci');

        $collection = new EntityCollection(1, 10, 1, 9, ...$users);
        $response = new EntityCollectionResponse($collection, new JsonFormatter());
        
        $expected[] = '{';
        $expected[] = '"page":1,';
        $expected[] = '"limit":10,';
        $expected[] = '"pages":1,';
        $expected[] = '"total":9,';
        $expected[] = '"items":[';
        $expected[] = '{"id":1,"name":"Federico","surname":"Maffucci","n":0},';
        $expected[] = '{"id":2,"name":"Lorenzo","surname":"Maffucci","n":0},';
        $expected[] = '{"id":3,"name":"Edoardo","surname":"Maffucci","n":0},';
        $expected[] = '{"id":4,"name":"Alessandro","surname":"Maffucci","n":0},';
        $expected[] = '{"id":5,"name":"Alessio","surname":"Maffucci","n":0},';
        $expected[] = '{"id":6,"name":"Manuele","surname":"Maffucci","n":0},';
        $expected[] = '{"id":7,"name":"Mattia","surname":"Maffucci","n":0},';
        $expected[] = '{"id":8,"name":"Francesco","surname":"Maffucci","n":0},';
        $expected[] = '{"id":9,"name":"Stefano","surname":"Maffucci","n":0}';
        $expected[] = ']';
        $expected[] = '}';
        $expected = implode('', $expected);
        
        $this->assertEquals($expected, sprintf($response));
    }

    // /**
    //  * Verifica corretta creazione e recupero dati Json con Hateoas
    //  */
    // public function testCreationJsonWithHateoas()
    // {
    //     Settings::addHateoasYamlDirPath(__DIR__ . '/yaml', 'MikroTest\Assets\Classes');
    //     $person = new FakeEntityUser(24, 'Federico', 'Maffucci');

    //     $response = new EntityCollectionResponse($person, new JsonFormatter());
    //     $this->assertEquals('{"fullname":"Federico Maffucci","_links":{"self":{"href":"\/fakeusers\/24"}}}', sprintf($response));
    //     Settings::resetHateoasYamlDirsPaths();
    // }
}
