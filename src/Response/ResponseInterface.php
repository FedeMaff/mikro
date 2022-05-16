<?php

/**
 * ResponseInterface.php
 * Mikro\Response\ResponseInterface
 *
 * PHP version 7.4
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Response;

/**
 * Interfaccia generica oggetto di risposta
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
interface ResponseInterface
{
    /**
     * Recupero contenuto response
     *
     * @return string
     */
    public function __toString(): string;
}
