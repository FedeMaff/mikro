<?php

/**
* FileWriteException.php
* Mikro\Exceptions\FileWriteException
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
* Implementazione concreta eccezione: "Scrittura file fallita"
*
* @category  Class
* @package   Mikro
* @author    Federico Maffucci <m4ffucci@gmail.com>
*/
class FileWriteException extends MikroException
{
   /**
    * Titolo generico eccezione
    *
    * @var string $title Titolo generico eccezione
    */
    protected string $title = 'Scrittura file fallita';

   /**
    * Percorso file
    *
    * @var string $filePath Percorso file
    */
    protected ?string $filePath = null;

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

   /**
    * Assegnazione percorso file
    *
    * @param string $filePath percorso file
    *
    * @return void
    */
    public function setFilePath(string $filePath): void
    {
        $this->filePath = $filePath;
    }

   /**
    * Recupero percorso file
    *
    * @return ?string
    */
    public function getFilePath(): ?string
    {
        return $this->filePath;
    }
}
