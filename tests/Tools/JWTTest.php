<?php

namespace MikroTest\Tools;

use PHPUnit\Framework\TestCase;
use Mikro\Tools\JWT;
use MikroTest\Assets\Classes\FakeHS256Encrypter as HS256;
use MikroTest\Assets\Classes\FakeRS256Encrypter as RS256;

class JWTTest extends TestCase
{
    /**
     * Verifica encode / decode con encrypter simmetrico
     */
    public function testHS256()
    {
        $dati['nome'] = 'Federico';
        $dati['cognome'] = 'Maffucci';
        $dati['email'] = 'm4ffucci@gmail.com';
        $jwt = JWT::encode($dati, new HS256, 60);
        $this->assertCount(3, explode('.', $jwt));
        $payload = JWT::decode($jwt, new HS256);
        $this->assertEquals('Federico', $payload['nome']);
        $this->assertEquals('Maffucci', $payload['cognome']);
        $this->assertEquals('m4ffucci@gmail.com', $payload['email']);
        $this->assertCount(5, $payload);
    }

    /**
     * Verifica encode / decode con encrypter asimmetrico
     */
    public function testRS256()
    {
        $dati['nome'] = 'Sergio';
        $dati['cognome'] = 'Lillito';
        $jwt = JWT::encode($dati, new RS256, 120);
        $this->assertCount(3, explode('.', $jwt));
        $payload = JWT::decode($jwt, new RS256);
        $this->assertEquals('Sergio', $payload['nome']);
        $this->assertEquals('Lillito', $payload['cognome']);
        $this->assertCount(4, $payload);
    }
}
