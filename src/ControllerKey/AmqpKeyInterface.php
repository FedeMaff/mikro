<?php

/**
 * AmqpKeyInterface.php
 * Mikro\ControllerKey\AmqpKeyInterface
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
 * Interfaccia identificativo chiave controller riservata a richieste AMQP
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
interface AmqpKeyInterface extends ControllerKeyInterface
{
    /**
     * Recupero nome evento
     *
     * @return string
     */
    public function getEventName(): string;
}
