<?php

/**
 * MikroExceptionInterface.php
 * Mikro\Exceptions\MikroExceptionInterface
 *
 * PHP version 7.4
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Exceptions;

use Mikro\Entity\EntityInterface;

/**
 * Interfaccia generica eccezione Mikro
 * Questa interfaccia definisce gli aspetti fondamentali di un errore
 * in modo da aderire allo standard rfc7807
 *
 * Standard: IETF RFC-7807 ( application/problem )
 * @link https://datatracker.ietf.org/doc/html/rfc7807
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
interface MikroExceptionInterface
{
    /**
     * Recupero percorso relativo di tipologia eccezione ( endpoint a html file )
     * Comde da specifica ietf rfc-7807 quando non esiste una rappresentazione di
     * dettaglio del problema è possibile restituire la stringa seguente: 'about:blank'
     *
     * @return string
     */
    public function getType(): string;

    /**
     * Recupero titolo porblema
     *
     * @return string
     */
    public function getTitle(): string;

    /**
     * Recupero codice di stato del problema
     *
     * @return int
     */
    public function getStatus(): int;

    /**
     * Recupero dettaglio specifico del porblema
     *
     * @return string
     */
    public function getDetail(): string;

    /**
     * Recupero entità di riferimento da cui si è sviluppato il porblema
     *
     * @return ?EntityInterface
     */
    public function getInstance(): ?EntityInterface;

    /**
     * Assegnazione entità di riferimento da cui si è sviluppato il porblema
     *
     * @param ?EntityInterface $instance Istanza entità
     *
     * @return void
     */
    public function setInstance(?EntityInterface $instance = null): void;
}
