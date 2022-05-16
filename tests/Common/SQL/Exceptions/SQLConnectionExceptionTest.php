<?php

namespace MikroTest\Common\SQL\Exceptions;

use PHPUnit\Framework\TestCase;
use Mikro\Factory\FormatterFactory;
use Mikro\Common\SQL\Exceptions\SQLConnectionException;

class SQLConnectionExceptionTest extends TestCase
{
    /**
     * Verifica corretta creazione conversione in json e reidratazione dati
     */
    public function testJsonOutput()
    {
        $exception = new SQLConnectionException('Nel tentativo di connettersi al servizio MySQL attraverso l\'utente "testphpunit" e\' stato riscontrato un errore, il servizio MySQL e\' inattivo.');
        $exception->setUsername('testphpunit');
        $exception->setHost('127.0.0.1');
        $exception->setPort(34901);

        /*
            #Rappresentazione in formato JSON
            {
              "type": "about:blank",
              "title": "Errore connessione SQL",
              "status": 500,
              "detail": "Nel tentativo di connettersi al servizio MySQL attraverso l'utente \"testphpunit\" e' stato riscontrato un errore, il servizio MySQL e' inattivo.",
              "username": "testphpunit",
              "host": "127.0.0.1",
              "port": 34901
            }
        */

        $json = (FormatterFactory::create(TYPE_JSON))->exceptionToString($exception);

        $expected['type'] = 'about:blank';
        $expected['title'] = 'Errore connessione SQL';
        $expected['status'] = SERVER_ERROR;
        $expected['detail'] = "Nel tentativo di connettersi al servizio MySQL attraverso l'utente \"testphpunit\" e' stato riscontrato un errore, il servizio MySQL e' inattivo.";
        $expected['username'] = 'testphpunit';
        $expected['host'] = '127.0.0.1';
        $expected['port'] = 34901;

        $this->assertEquals($expected, json_decode($json, true));
    }
}
