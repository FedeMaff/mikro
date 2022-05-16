<?php

namespace MikroTest\Common\SQL\Exceptions;

use PHPUnit\Framework\TestCase;
use Mikro\Factory\FormatterFactory;
use Mikro\Common\SQL\Exceptions\SQLQueryException;

class SQLQueryExceptionTest extends TestCase
{
    /**
     * Verifica corretta creazione conversione in json e reidratazione dati
     */
    public function testJsonOutput()
    {
        $exception = new SQLQueryException('Non esiste una colonna di nome \'email\' nella tabella \'utenti\'');
        $exception->setQuery('SELECT * FROM `utenti` WHERE `email` LIKE :field_email_001');
        $exception->setQueryParams(['field_email_001' => 'f.maff%']);

        /*
            #Rappresentazione in formato JSON
            {
              "type": "about:blank",
              "title": "Errore query SQL",
              "status": 500,
              "detail": "Non esiste una colonna di nome 'email' nella tabella 'utenti'",
              "query": "SELECT * FROM `utenti` WHERE `email` LIKE :field_email_001",
              "queryParams": {
                "field_email_001": "f.maff%"
              }
            }
        */

        $json = (FormatterFactory::create(TYPE_JSON))->exceptionToString($exception);

        $expected['type'] = 'about:blank';
        $expected['title'] = 'Errore query SQL';
        $expected['status'] = SERVER_ERROR;
        $expected['detail'] = 'Non esiste una colonna di nome \'email\' nella tabella \'utenti\'';
        $expected['query'] = 'SELECT * FROM `utenti` WHERE `email` LIKE :field_email_001';
        $expected['queryParams'] = ['field_email_001' => 'f.maff%'];

        $this->assertEquals($expected, json_decode($json, true));
    }
}
