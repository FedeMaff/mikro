<?php

/**
 * HttpResponseInterface.php
 * Mikro\Response\HttpResponseInterface
 *
 * PHP version 7.4
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Response;

use Mikro\Response\ResponseInterface;

/**
 * Interfaccia oggetto di risposta HTTP
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
interface HttpResponseInterface extends ResponseInterface
{
    /**
     * Recupero codice di stato risposta
     *
     * @return int
     */
    public function getStatusCode(): int;

    /**
     * Recupero frase descrittiva di accompagnamento al codice di stato risposta
     *
     * @return string
     */
    public function getReasonPhrase(): string;

    /**
     * Recupero elenco chiave/valore proprietà di header
     *
     * @return array
     */
    public function getHeaders(): array;
}
