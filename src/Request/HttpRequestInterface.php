<?php

/**
 * HttpRequestInterface.php
 * Mikro\Request\HttpRequestInterface
 *
 * PHP version 7.4
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Request;

use Mikro\Request\RequestInterface;

/**
 * Interfaccia richiesta HTTP
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
interface HttpRequestInterface extends RequestInterface
{
    /**
     * Recupero metodo HTTP
     *
     * @return string
     */
    public function getMethod(): string;

    /**
     * Recupero percorso URL
     *
     * @return string
     */
    public function getPath(): string;

    /**
     * Recupero parametri derivanti da Header di richiesta
     *
     * @return array
     */
    public function getHeaders(): array;

    /**
     * Recupero elenco file multipart
     *
     * @return array
     */
    public function getFiles(): array;

    /**
     * Recupero formato di output accettato
     * Qual'ora non vi sia un formato gestito da microservice verrà
     * restituito il formato json.
     *
     * @return string
     */
    public function getOutputFormat(): string;
}
