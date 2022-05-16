<?php

/**
* NotSetException.php
* Mikro\Exceptions\NotSetException
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
* Implementazione concreta eccezione: "Proprietà o variabile non impostata"
*
* @category  Class
* @package   Mikro
* @author    Federico Maffucci <m4ffucci@gmail.com>
*/
class NotSetException extends MikroException
{
   /**
    * Titolo generico eccezione
    *
    * @var string $title Titolo generico eccezione
    */
    protected string $title = 'Proprieta\' o variabile non impostata';

    /**
    * Costrutture
    *
    * @var string $message Dettaglio messaggio di errore
    * @var int $code Codice di errore
    * @var Throwable $previous istanza Throwable
    */
    public function __construct(string $message = '', int $code = SERVER_ERROR, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
