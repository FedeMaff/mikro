<?php

/**
 * CliKey.php
 * Mikro\ControllerKey\CliKey
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\ControllerKey;

use Mikro\ControllerKey\CliKeyInterface;

/**
 * Implementazione concreta chiave controller riservata a richieste CLI
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

class CliKey implements CliKeyInterface
{
    /**
     * Nome comando
     *
     * @var string $commandName Nome comando CLI
    */
    private string $commandName = '';

    /**
     * Costruttore
     *
     * @param string $className Nome istanza ControllerCLIInterface
     */
    public function __construct(string $className)
    {
        $this->commandName = $className::getCommandName();
    }

    /**
     * Recupero Nome comando
     *
     * @return string
    */
    public function getCommandName(): string
    {
        return $this->commandName;
    }
}
