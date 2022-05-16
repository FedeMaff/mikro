<?php

/**
 * ConfInterface.php
 * Mikro\Common\HTTP\Configuration\ConfInterface
 *
 * PHP version 7.4
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Common\HTTP\Configuration;

/**
 * Interfaccia configurazione connessione HTTP
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
interface ConfInterface
{
    /**
     * Recupero host / ip
     *
     * @return ?string
     */
    public function getHost(): ?string;

    /**
     * Recupero porta
     *
     * @return ?int
     */
    public function getPort(): ?int;
}
