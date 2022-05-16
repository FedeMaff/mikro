<?php

namespace MikroTest\Exceptions;

use PHPUnit\Framework\TestCase;
use Mikro\Factory\FormatterFactory;
use Mikro\Exceptions\AlreadyExistsException;

class AlreadyExistsExceptionTest extends TestCase
{
    /**
     * Verifica corretta creazione conversione in json e reidratazione dati
     */
    public function testJsonOutput()
    {
        $exception = new AlreadyExistsException('Un\' entita\' particolare esiste gia\'');

        /*
            #Rappresentazione in formato JSON
            {
              "type": "about:blank",
              "title": "Oggetto o Entita' gia' presente",
              "status": 404,
              "detail": "Un' entita' particolare esiste gia'"
            }
        */

        $json = (FormatterFactory::create(TYPE_JSON))->exceptionToString($exception);

        $expected['type'] = 'about:blank';
        $expected['title'] = 'Oggetto o Entita\' gia\' presente';
        $expected['status'] = 500;
        $expected['detail'] = "Un' entita' particolare esiste gia'";

        $this->assertEquals($expected, json_decode($json, true));
    }
}
