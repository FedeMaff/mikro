<?php

/**
 * CliKeyInterface.php
 * Mikro\ControllerKey\CliKeyInterface
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
 * Interfaccia identificativo chiave controller riservata a richieste CLI
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
interface CliKeyInterface extends ControllerKeyInterface
{
    /**
     * Recupero nome comando
     *
     * @return string
     */
    public function getCommandName(): string;
}
