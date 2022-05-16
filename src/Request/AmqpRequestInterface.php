<?php

/**
 * AmqpRequestInterface.php
 * Mikro\Request\AmqpRequestInterface
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
 * Interfaccia richiesta AMQP
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
interface AmqpRequestInterface extends RequestInterface
{
    /**
     * Recupero nome dell'evento
     *
     * @return string
     */
    public function getEventName(): string;
}
