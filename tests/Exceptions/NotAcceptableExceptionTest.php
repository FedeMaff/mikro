<?php

namespace MikroTest\Exceptions;

use PHPUnit\Framework\TestCase;
use Mikro\Factory\FormatterFactory;
use Mikro\Exceptions\NotAcceptableException;

class NotAcceptableExceptionTest extends TestCase
{
    /**
     * Verifica corretta creazione conversione in json e reidratazione dati
     */
    public function testJsonOutput()
    {
        $exception = new NotAcceptableException('Il Token JWT non e\' ancora attivo!');

        /*
            #Rappresentazione in formato JSON
            {
              "type": "about:blank",
              "title": "Richiesta non accettabile",
              "status": 406,
              "detail": "Il Token JWT non e' ancora attivo!"
            }
        */

        $json = (FormatterFactory::create(TYPE_JSON))->exceptionToString($exception);

        $expected['type'] = 'about:blank';
        $expected['title'] = 'Richiesta non accettabile';
        $expected['status'] = 406;
        $expected['detail'] = "Il Token JWT non e' ancora attivo!";

        $this->assertEquals($expected, json_decode($json, true));
    }
}
