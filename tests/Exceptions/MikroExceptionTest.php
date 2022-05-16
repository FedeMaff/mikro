<?php

namespace MikroTest\Exceptions;

use PHPUnit\Framework\TestCase;
use Mikro\Factory\FormatterFactory;
use Mikro\Exceptions\MikroException;

class MikroExceptionTest extends TestCase
{
    /**
     * Verifica corretta creazione conversione in json e reidratazione dati
     */
    public function testJsonOutput()
    {
        $exception = new MikroException('Messaggio di errore specifico');

        /*
            #Rappresentazione in formato JSON
            {
              "type": "about:blank",
              "title": "",
              "status": 0,
              "detail": "Messaggio di errore specifico"
            }
        */

        $json = (FormatterFactory::create(TYPE_JSON))->exceptionToString($exception);

        $expected['type'] = 'about:blank';
        $expected['title'] = '';
        $expected['status'] = 0;
        $expected['detail'] = "Messaggio di errore specifico";

        $this->assertEquals($expected, json_decode($json, true));
    }
}
