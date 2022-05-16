<?php

/**
 * HttpControllerInterface.php
 * Mikro\Controller\HttpControllerInterface
 *
 * PHP version 7.4
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Controller;

use Mikro\Controller\ControllerInterface;
use Mikro\Response\ResponseInterface;

/**
 * Interfaccia controller utilizzabile in risposta a richieste HTTP
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
interface HttpControllerInterface extends ControllerInterface
{
    /**
     * Recupero metodo
     *
     * @return string
     */
    public static function getMethod(): string;

    /**
     * Recupero percorso di riferimento
     *
     * @return string
     */
    public static function getPath(): string;

    /**
     * Esecuzione controller e logiche di business implementate
     *
     * @return ?ResponseInterface
     */
    public function run(): ?ResponseInterface;
}
