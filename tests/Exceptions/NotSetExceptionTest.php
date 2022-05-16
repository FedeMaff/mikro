<?php

namespace MikroTest\Exceptions;

use PHPUnit\Framework\TestCase;
use Mikro\Factory\FormatterFactory;
use Mikro\Exceptions\NotSetException;

class NotSetExceptionTest extends TestCase
{
    /**
     * Verifica corretta creazione conversione in json e reidratazione dati
     */
    public function testJsonOutput()
    {
        $exception = new NotSetException('Qualcosa di preciso non e\' stato valorizzato');

        /*
            #Rappresentazione in formato JSON
            {
              "type": "about:blank",
              "title": "Proprieta' o variabile non impostata",
              "status": 500,
              "detail": "Qualcosa di preciso non e' stato valorizzato"
            }
        */

        $json = (FormatterFactory::create(TYPE_JSON))->exceptionToString($exception);

        $expected['type'] = 'about:blank';
        $expected['title'] = 'Proprieta\' o variabile non impostata';
        $expected['status'] = 500;
        $expected['detail'] = "Qualcosa di preciso non e' stato valorizzato";

        $this->assertEquals($expected, json_decode($json, true));
    }
}
