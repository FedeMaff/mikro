<?php

namespace MikroTest\Exceptions;

use PHPUnit\Framework\TestCase;
use Mikro\Factory\FormatterFactory;
use Mikro\Exceptions\ParamsValidationException;

class ParamsValidationExceptionTest extends TestCase
{
    /**
     * Verifica corretta creazione conversione in json e reidratazione dati
     */
    public function testJsonOutput()
    {
        $errors['e-mail'][] = "Formato indirizzo e-mail non valido";
        $errors['password'][] = "La lunghezza della password deve essere di almeno 8 caratteri";
        $errors['password'][] = "La password non contiene numeri e lettere";
        $errors['password'][] = "La password è vuota";
        $exception = new ParamsValidationException('Validazione dati utente fallita', $errors);

        /*
            #Rappresentazione in formato JSON
            {
              "type": "about:blank",
              "title": "Parametri richiesta non validi",
              "status": 400,
              "detail": "Validazione dati utente fallita",
              "invalidParams": {
                "e-mail": [
                  "Formato indirizzo e-mail non valido"
                ],
                "password": [
                  "La lunghezza della password deve essere di almeno 8 caratteri",
                  "La password non contiene numeri e lettere",
                  "La password \u00e8 vuota"
                ]
              }
            }
        */

        $json = (FormatterFactory::create(TYPE_JSON))->exceptionToString($exception);

        $expected['type'] = 'about:blank';
        $expected['title'] = 'Parametri richiesta non validi';
        $expected['status'] = BAD_REQUEST;
        $expected['detail'] = "Validazione dati utente fallita";
        $expected['invalidParams'] = [
            "e-mail" => [ "Formato indirizzo e-mail non valido" ],
            "password" => [ "La lunghezza della password deve essere di almeno 8 caratteri", "La password non contiene numeri e lettere", "La password è vuota" ],
        ];

        $this->assertEquals($expected, json_decode($json, true));
    }
}
