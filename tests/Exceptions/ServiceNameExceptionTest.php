<?php

namespace MikroTest\Exceptions;

use PHPUnit\Framework\TestCase;
use Mikro\Factory\FormatterFactory;
use Mikro\Exceptions\ServiceNameException;

class ServiceNameExceptionTest extends TestCase
{
    /**
     * Verifica corretta creazione conversione in json e reidratazione dati
     */
    public function testJsonOutput()
    {
        $exception = new ServiceNameException('Il nome del servizio include spazi non va bene!');

        /*
            #Rappresentazione in formato JSON
            {
              "type": "about:blank",
              "title": "Nome servizio non valido",
              "status": 500,
              "detail": "Il nome del servizio include spazi non va bene!"
            }
        */

        $json = (FormatterFactory::create(TYPE_JSON))->exceptionToString($exception);

        $expected['type'] = 'about:blank';
        $expected['title'] = 'Nome servizio non valido';
        $expected['status'] = 500;
        $expected['detail'] = "Il nome del servizio include spazi non va bene!";

        $this->assertEquals($expected, json_decode($json, true));
    }
}
