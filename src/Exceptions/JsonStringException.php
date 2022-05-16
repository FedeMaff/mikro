<?php

/**
* JsonStringException.php
* Mikro\Exceptions\JsonStringException
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
* Implementazione concreta eccezione: "Errore conversione JSON"
*
* @category  Class
* @package   Mikro
* @author    Federico Maffucci <m4ffucci@gmail.com>
*/
class JsonStringException extends MikroException
{
   /**
    * Titolo generico eccezione
    *
    * @var string $title Titolo generico eccezione
    */
    protected string $title = 'Stringa JSON non parsificabile';

   /**
    * Contenuto stringa JSON
    *
    * @var string $jsonString Contenuto stringa JSON
    */
    protected ?string $jsonString = null;

    /**
    * Costrutture
    *
    * @var string $message Dettaglio messaggio di errore
    * @var int $code Codice di errore
    * @var Throwable $previous istanza Throwable
    */
    public function __construct(string $message = '', int $code = BAD_REQUEST, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

   /**
    * Assegnazione stringa JSON
    *
    * @param string $jsonString stringa JSON
    *
    * @return void
    */
    public function setJsonString(string $jsonString): void
    {
        $this->jsonString = $jsonString;
    }

   /**
    * Recupero stringa JSON
    *
    * @return ?string
    */
    public function getJsonString(): ?string
    {
        return $this->jsonString;
    }
}
