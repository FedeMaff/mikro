<?php

/**
* ParamsValidationException.php
* Mikro\Exceptions\ParamsValidationException
*
* PHP version 7.4
*
* @category  Class
* @package   Mikro
* @author    Federico Maffucci <m4ffucci@gmail.com>
*/

namespace Mikro\Exceptions;

use Mikro\Exceptions\MikroException;

/**
* Implementazione concreta eccezione: "Validazione parametri non riuscita"
*
* @category  Class
* @package   Mikro
* @author    Federico Maffucci <m4ffucci@gmail.com>
*/
class ParamsValidationException extends MikroException
{
   /**
    * Titolo generico eccezione
    *
    * @var string $title Titolo generico eccezione
    */
    protected string $title = 'Parametri richiesta non validi';

   /**
    * Elenco parametri non validi
    *
    * Esempio
    * [
    *    "name" => [
    *       0 => "Il campo nome non è valido",
    *       1 => "Non sono ammessi spazzi"
    *    ],
    *    "email" => [
    *       0 => "Formato e-mail non valido"
    *    ]
    * ]
    *
    * @var array[] $invalidParams Elenco parametri non validi
    */
    protected array $invalidParams = [];

   /**
    * Costrutture
    *
    * @var string $message Dettaglio messaggio di errore
    * @var array[] $invalidParams Elenco di parametri non validi con relativa descrizione
    */
    public function __construct(string $message = '', array $invalidParams = [])
    {
        parent::__construct($message, BAD_REQUEST);
        $this->invalidParams = $invalidParams;
    }
}
