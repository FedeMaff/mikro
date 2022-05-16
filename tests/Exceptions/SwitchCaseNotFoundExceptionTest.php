<?php

namespace MikroTest\Exceptions;

use PHPUnit\Framework\TestCase;
use Mikro\Factory\FormatterFactory;
use Mikro\Exceptions\SwitchCaseNotFoundException;

class SwitchCaseNotFoundExceptionTest extends TestCase
{
    /**
     * Verifica corretta creazione conversione in json e reidratazione dati
     */
    public function testJsonOutput()
    {
        $exception = new SwitchCaseNotFoundException('Switch non valido per motivi x,y e z');

        /*
            #Rappresentazione in formato JSON
            {
              "type": "about:blank",
              "title": "Case switch non trovato",
              "status": 500,
              "detail": "Switch non valido per motivi x,y e z"
            }
        */

        $json = (FormatterFactory::create(TYPE_JSON))->exceptionToString($exception);

        $expected['type'] = 'about:blank';
        $expected['title'] = 'Case switch non trovato';
        $expected['status'] = 500;
        $expected['detail'] = "Switch non valido per motivi x,y e z";

        $this->assertEquals($expected, json_decode($json, true));
    }
}
