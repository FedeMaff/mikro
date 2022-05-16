<?php

/**
* SQLConnectionException.php
* Mikro\Common\SQL\Exceptions\SQLConnectionException
*
* PHP version 7.4
*
* @category  Class
* @package   Mikro
* @author    Federico Maffucci <m4ffucci@gmail.com>
*/

namespace Mikro\Common\SQL\Exceptions;

use Mikro\Exceptions\MikroException;

/**
* Implementazione concreta eccezione: "Errore di connessione SQL"
*
* @category  Class
* @package   Mikro
* @author    Federico Maffucci <m4ffucci@gmail.com>
*/
class SQLConnectionException extends MikroException
{
   /**
   * Titolo generico eccezione
   *
   * @var string $title Titolo generico eccezione
   */
    protected string $title = 'Errore connessione SQL';

   /**
    * Nome utente
    *
    * @var string $username Nome utente
    */
    protected ?string $username = null;

   /**
    * Nome host o ip di riferimento
    *
    * @var string $host Nome host / ip
    */
    protected ?string $host = null;

   /**
    * Numero porta
    *
    * @var int $port Porta TCP
    */
    protected int $port = 3306;

   /**
    * Costrutture
    *
    * @param string $message Dettaglio messaggio di errore
    * @param int $code Codice di errore
    * @param Throwable $previous istanza Throwable
    */
    public function __construct(string $message = '', int $code = SERVER_ERROR, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

   /**
    * Assegnazione nome utente
    *
    * @param string $username Nome utente
    *
    * @return void
    */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

   /**
    * Assegnazione nome host / ip
    *
    * @param string $host Nome host / ip
    *
    * @return void
    */
    public function setHost(string $host): void
    {
        $this->host = $host;
    }

   /**
    * Assegnazione numero porta
    *
    * @param int $port Numero porta
    *
    * @return void
    */
    public function setPort(int $port): void
    {
        $this->port = $port;
    }

   /**
    * Recupero nome utente
    *
    * @return ?string
    */
    public function getUsername(): ?string
    {
        return $this->username;
    }

   /**
    * Recupero nome host / ip
    *
    * @return ?string
    */
    public function getHost(): ?string
    {
        return $this->host;
    }

   /**
    * Recupero numero porta
    *
    * @return int
    */
    public function getPort(): int
    {
        return $this->port;
    }
}
