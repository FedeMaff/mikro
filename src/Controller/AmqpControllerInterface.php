<?php

/**
 * AmqpControllerInterface.php
 * Mikro\Controller\AmqpControllerInterface
 *
 * PHP version 7.4
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Controller;

use Mikro\Controller\ControllerInterface;

/**
 * Interfaccia controller utilizzabile in risposta a richieste AMQP
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
interface AmqpControllerInterface extends ControllerInterface
{
    /**
     * Recupero nome evento di riferimento
     *
     * @return string
     */
    public static function getEventName(): string;

    /**
     * Esecuzione controller e logiche di business implementate
     *
     * @return void
     */
    public function run(): void;
}
