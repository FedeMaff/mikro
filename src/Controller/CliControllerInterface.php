<?php

/**
 * CliControllerInterface.php
 * Mikro\Controller\CliControllerInterface
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
 * Interfaccia controller utilizzabile in risposta a richieste CLI
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
interface CliControllerInterface extends ControllerInterface
{
    /**
     * Recupero nome comando di riferimento
     *
     * @return string
     */
    public static function getCommandName(): string;

    /**
     * Esecuzione controller e logiche di business implementate
     *
     * @return ?ResponseInterface
     */
    public function run(): ?ResponseInterface;
}
