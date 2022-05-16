<?php

/**
 * CliRequestInterface.php
 * Mikro\Request\CliRequestInterface
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
 * Interfaccia richiesta CLI
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
interface CliRequestInterface extends RequestInterface
{
    /**
     * Recupero nome comando
     *
     * @return string
     */
    public function getCommandName(): string;
}
