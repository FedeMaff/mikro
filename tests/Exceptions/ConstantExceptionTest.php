<?php

namespace MikroTest\Exceptions;

use PHPUnit\Framework\TestCase;
use Mikro\Factory\FormatterFactory;
use Mikro\Exceptions\ConstantException;

class ConstantExceptionTest extends TestCase
{
    /**
     * Verifica corretta creazione conversione in json e reidratazione dati
     */
    public function testJsonOutput()
    {
        $exception = new ConstantException('La costante di prova FD_CO non e\' vlida');

        /*
            #Rappresentazione in formato JSON
            {
              "type": "about:blank",
              "title": "Costante non valida",
              "status": 500,
              "detail": "La costante di prova FD_CO non e' vlida"
            }
        */

        $json = (FormatterFactory::create(TYPE_JSON))->exceptionToString($exception);

        $expected['type'] = 'about:blank';
        $expected['title'] = 'Costante non valida';
        $expected['status'] = 500;
        $expected['detail'] = "La costante di prova FD_CO non e' vlida";

        $this->assertEquals($expected, json_decode($json, true));
    }
}
