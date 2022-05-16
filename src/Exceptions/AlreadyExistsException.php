<?php

/**
* AlreadyExistsException.php
* Mikro\Exceptions\AlreadyExistsException
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
 * Implementazione concreta eccezione: "L'oggetto o lentità esiste già"
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class AlreadyExistsException extends MikroException
{
   /**
    * Titolo generico eccezione
    *
    * @var string $title Titolo generico eccezione
    */
    protected string $title = 'Oggetto o Entita\' gia\' presente';

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
