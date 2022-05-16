<?php

/**
 * AmqpKey.php
 * Mikro\ControllerKey\AmqpKey
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\ControllerKey;

use Mikro\ControllerKey\AmqpKeyInterface;

/**
 * Implementazione concreta chiave controller riservata a richieste AMQP
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class AmqpKey implements AmqpKeyInterface
{
    /**
     * Nome evento
     *
     * @var string $eventName Nome evento AMQP
    */
    private string $eventName = '';

    /**
     * Costruttore
     *
     * @param string $className Nome istanza ControllerAMQPInterface
     */
    public function __construct(string $className)
    {
        $this->eventName = $className::getEventName();
    }

    /**
     * Recupero nome evento
     *
     * @return string
     */
    public function getEventName(): string
    {
        return $this->eventName;
    }
}
