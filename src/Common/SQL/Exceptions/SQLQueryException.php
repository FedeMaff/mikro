<?php

/**
* SQLQueryException.php
* Mikro\Common\SQL\Exceptions\SQLQueryException
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
* Implementazione concreta eccezione: "Errore di query SQL"
*
* @category  Class
* @package   Mikro
* @author    Federico Maffucci <m4ffucci@gmail.com>
*/
class SQLQueryException extends MikroException
{
   /**
   * Titolo generico eccezione
   *
   * @var string $title Titolo generico eccezione
   */
    protected string $title = 'Errore query SQL';

   /**
    * Stringa query
    *
    * @var string $query Stringa SQL
    */
    protected ?string $query = null;

   /**
    * Elenco di parametri da sostituire ai placeholder nella query
    *
    * @var array $queryParams Parametri di query
    */
    protected array $queryParams = [];

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
    * Assegnazione stringa query
    *
    * @param string $query Stringa SQL
    *
    * @return void
    */
    public function setQuery(string $query): void
    {
        $this->query = $query;
    }

   /**
    * Assegnazione parametri di query
    *
    * @param array $queryParams Parametri di query
    *
    * @return void
    */
    public function setQueryParams(array $queryParams): void
    {
        $this->queryParams = $queryParams;
    }

   /**
    * Recupero stringa query
    *
    * @return ?string
    */
    public function getQuery(): ?string
    {
        return $this->query;
    }

   /**
    * Recupero parametri di query
    *
    * @return array
    */
    public function getQueryParams(): array
    {
        return $this->queryParams;
    }
}
