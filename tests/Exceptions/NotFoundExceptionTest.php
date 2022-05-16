<?php

namespace MikroTest\Exceptions;

use PHPUnit\Framework\TestCase;
use Mikro\Factory\FormatterFactory;
use Mikro\Exceptions\NotFoundException;

class NotFoundExceptionTest extends TestCase
{
    /**
     * Verifica corretta creazione conversione in json e reidratazione dati
     */
    public function testJsonOutput()
    {
        $exception = new NotFoundException('Qualcosa di preciso non e\' stato trovato');

        /*
            #Rappresentazione in formato JSON
            {
              "type": "about:blank",
              "title": "Risorsa non trovata",
              "status": 404,
              "detail": "Qualcosa di preciso non e' stato trovato"
            }
        */

        $json = (FormatterFactory::create(TYPE_JSON))->exceptionToString($exception);

        $expected['type'] = 'about:blank';
        $expected['title'] = 'Risorsa non trovata';
        $expected['status'] = 404;
        $expected['detail'] = "Qualcosa di preciso non e' stato trovato";

        $this->assertEquals($expected, json_decode($json, true));
    }
}
