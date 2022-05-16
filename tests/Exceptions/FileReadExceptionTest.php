<?php

namespace MikroTest\Exceptions;

use PHPUnit\Framework\TestCase;
use Mikro\Factory\FormatterFactory;
use Mikro\Exceptions\FileReadException;

class FileReadExceptionTest extends TestCase
{
    /**
     * Verifica corretta creazione conversione in json e reidratazione dati
     */
    public function testJsonOutput()
    {
        $exception = new FileReadException('Messaggio di errore specifico file non letto');
        $exception->setFilePath('./prova/file.png');

        /*
            #Rappresentazione in formato JSON
            {
              "type": "about:blank",
              "title": "Lettura file fallita",
              "status": 500,
              "detail": "Messaggio di errore specifico file non letto",
              "filePath": "./prova/file.png"
            }
        */

        $json = (FormatterFactory::create(TYPE_JSON))->exceptionToString($exception);

        $expected['type'] = 'about:blank';
        $expected['title'] = 'Lettura file fallita';
        $expected['status'] = 500;
        $expected['detail'] = "Messaggio di errore specifico file non letto";
        $expected['filePath'] = "./prova/file.png";

        $this->assertEquals($expected, json_decode($json, true));
    }
}
