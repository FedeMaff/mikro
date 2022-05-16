<?php

/**
 * HttpKeyInterface.php
 * Mikro\ControllerKey\HttpKeyInterface
 *
 * PHP version 7.4
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\ControllerKey;

use Mikro\ControllerKey\ControllerKeyInterface;

/**
 * Interfaccia identificativo chiave controller riservata a richieste HTTP
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
interface HttpKeyInterface extends ControllerKeyInterface
{
    /**
     * Recupero metodo http
     *
     * @return string
     */
    public function getMethod(): string;

    /**
     * Recupero path
     *
     * @return string
     */
    public function getPath(): string;
}
