<?php

/**
* MikroException.php
* Mikro\Exceptions\MikroException
*
* PHP version 7.4
*
* @category  Class
* @package   Mikro
* @author    Federico Maffucci <m4ffucci@gmail.com>
*/

namespace Mikro\Exceptions;

use Mikro\Exceptions\MikroExceptionInterface;
use Mikro\Entity\EntityInterface;
use Exception;

/**
* Implementazione concreta eccezione Mikro
*
* @category  Class
* @package   Mikro
* @author    Federico Maffucci <m4ffucci@gmail.com>
*/
class MikroException extends Exception implements MikroExceptionInterface
{
    /**
     * Percorso relativo documento html di dettaglio o about:blank
     *
     * @var string $type Percorso
     */
    protected string $type = 'about:blank';

    /**
     * Titolo generico eccezione
     *
     * @var string $title Titolo generico eccezione
     */
    protected string $title = '';

    /**
     * Istanza entità di riferimento
     *
     * @var ?EntityInterface $instance Istanza Entità di riferimento
     */
    protected ?EntityInterface $instance = null;


    /**
    * Recupero percorso relativo di tipologia eccezione ( endpoint a html file )
    * Comde da specifica ietf rfc-7807 quando non esiste una rappresentazione di
    * dettaglio del problema è possibile restituire la stringa seguente: 'about:blank'
    *
    * @return string
    */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Recupero titolo porblema
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
    * Recupero codice di stato del problema
    *
    * @return int
    */
    public function getStatus(): int
    {
        return $this->code;
    }

    /**
    * Recupero dettaglio specifico del porblema
    *
    * @return string
    */
    public function getDetail(): string
    {
        return $this->message;
    }

    /**
    * Recupero entità di riferimento da cui si è sviluppato il porblema
    *
    * @return ?EntityInterface
    */
    public function getInstance(): ?EntityInterface
    {
        return $this->instance;
    }

    /**
    * Assegnazione entità di riferimento da cui si è sviluppato il porblema
    *
    * @param ?EntityInterface $instance Istanza entità
    *
    * @return void
    */
    public function setInstance(?EntityInterface $instance = null): void
    {
        $this->instance = $instance;
    }
}
