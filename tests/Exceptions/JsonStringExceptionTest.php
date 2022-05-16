<?php

namespace MikroTest\Exceptions;

use PHPUnit\Framework\TestCase;
use Mikro\Factory\FormatterFactory;
use Mikro\Exceptions\JsonStringException;

class JsonStringExceptionTest extends TestCase
{
    /**
     * Verifica corretta creazione conversione in json e reidratazione dati
     */
    public function testJsonOutput()
    {
        $exception = new JsonStringException('La stringa prova ha dato problemi');
        $exception->setJsonString('{"prova":"prova"}');

        /*
            #Rappresentazione in formato JSON
            {
              "type": "about:blank",
              "title": "Stringa JSON non parsificabile",
              "status": 400,
              "detail": "La stringa prova ha dato problemi"
              "jsonString": "{\"prova\":\"prova\"}"
            }
        */

        $json = (FormatterFactory::create(TYPE_JSON))->exceptionToString($exception);

        $expected['type'] = 'about:blank';
        $expected['title'] = 'Stringa JSON non parsificabile';
        $expected['status'] = 400;
        $expected['detail'] = "La stringa prova ha dato problemi";
        $expected['jsonString'] = '{"prova":"prova"}';

        $this->assertEquals($expected, json_decode($json, true));
    }
}
