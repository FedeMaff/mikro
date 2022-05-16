<?php

/**
* NotFoundException.php
* Mikro\Exceptions\NotFoundException
*
* PHP version 7.4
*
* @category  Class
* @package   Mikro
* @author    Federico Maffucci <m4ffucci@gmail.com>
*/

namespace Mikro\Exceptions;

use Mikro\Exceptions\MikroException;
use Throwable;

/**
* Implementazione concreta eccezione: "Risorsa non trovata"
*
* @category  Class
* @package   Mikro
* @author    Federico Maffucci <m4ffucci@gmail.com>
*/
class NotFoundException extends MikroException
{
   /**
    * Titolo generico eccezione
    *
    * @var string $title Titolo generico eccezione
    */
    protected string $title = 'Risorsa non trovata';

    /**
    * Costrutture
    *
    * @var string $message Dettaglio messaggio di errore
    * @var int $code Codice di errore
    * @var Throwable $previous istanza Throwable
    */
    public function __construct(string $message = '', int $code = NOT_FOUND, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
