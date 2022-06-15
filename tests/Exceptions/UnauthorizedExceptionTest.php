<?php

namespace MikroTest\Exceptions;

use PHPUnit\Framework\TestCase;
use Mikro\Factory\FormatterFactory;
use Mikro\Exceptions\UnauthorizedException;

class UnauthorizedExceptionTest extends TestCase
{
    /**
     * Verifica corretta creazione conversione in json e reidratazione dati
     */
    public function testJsonOutput()
    {
        $exception = new UnauthorizedException('Il token JWT impostato non e\' ritenuto valido');

        /*
            #Rappresentazione in formato JSON
            {
              "type": "about:blank",
              "title": "Accesso non autorizzato",
              "status": 401,
              "detail": "Il token JWT impostato non e' ritenuto valido"
            }
        */

        $json = (FormatterFactory::create(TYPE_JSON))->exceptionToString($exception);

        $expected['type'] = 'about:blank';
        $expected['title'] = 'Accesso non autorizzato';
        $expected['status'] = 401;
        $expected['detail'] = "Il token JWT impostato non e' ritenuto valido";

        $this->assertEquals($expected, json_decode($json, true));
    }
}
