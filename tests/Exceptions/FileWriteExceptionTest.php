<?php

namespace MikroTest\Exceptions;

use PHPUnit\Framework\TestCase;
use Mikro\Factory\FormatterFactory;
use Mikro\Exceptions\FileWriteException;

class FileWriteExceptionTest extends TestCase
{
    /**
     * Verifica corretta creazione conversione in json e reidratazione dati
     */
    public function testJsonOutput()
    {
        $exception = new FileWriteException('Messaggio di errore specifico');
        $exception->setFilePath('./prova/file.txt');

        /*
            #Rappresentazione in formato JSON
            {
              "type": "about:blank",
              "title": "Scrittura file fallita",
              "status": 500,
              "detail": "Messaggio di errore specifico",
              "filePath": "./prova/file.txt"
            }
        */

        $json = (FormatterFactory::create(TYPE_JSON))->exceptionToString($exception);

        $expected['type'] = 'about:blank';
        $expected['title'] = 'Scrittura file fallita';
        $expected['status'] = 500;
        $expected['detail'] = "Messaggio di errore specifico";
        $expected['filePath'] = "./prova/file.txt";

        $this->assertEquals($expected, json_decode($json, true));
    }
}
