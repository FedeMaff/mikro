<?php

namespace MikroTest\Exceptions;

use PHPUnit\Framework\TestCase;
use Mikro\Factory\FormatterFactory;
use Mikro\Exceptions\NotValidException;

class NotValidExceptionTest extends TestCase
{
    /**
     * Verifica corretta creazione conversione in json e reidratazione dati
     */
    public function testJsonOutput()
    {
        $exception = new NotValidException('Il contenuto di "dateTime" non e\' corretto');

        /*
            #Rappresentazione in formato JSON
            {
              "type": "about:blank",
              "title": "Valore proprieta\' non valido",
              "status": 400,
              "detail": "Il contenuto di \"dateTime\" non e' corretto"
            }
        */

        $json = (FormatterFactory::create(TYPE_JSON))->exceptionToString($exception);

        $expected['type'] = 'about:blank';
        $expected['title'] = 'Valore proprieta\' non valido';
        $expected['status'] = 400;
        $expected['detail'] = "Il contenuto di \"dateTime\" non e' corretto";

        $this->assertEquals($expected, json_decode($json, true));
    }
}
