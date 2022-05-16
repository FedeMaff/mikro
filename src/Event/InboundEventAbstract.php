<?php

/**
 * InboundEventAbstract.php
 * Mikro\Event\InboundEventAbstract
 *
 * PHP version 7.4
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Event;

use Mikro\Event\EventAbstract;
use Mikro\Request\AmqpRequestInterface;

/**
 * Implementazione astratta evento in ingresso
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
abstract class InboundEventAbstract extends EventAbstract implements AmqpRequestInterface
{
    /**
     * Recupero nome dell'evento
     * Il nome dell'evento è rappresentato dalla concatenazione tra sender
     * ovvero nome del servizio "mittente" ed il nome vero è proprio dell'evento.
     *
     * @return string
     */
    public function getEventName(): string
    {
        return sprintf('%s.%s', $this->getSender(), $this->getName());
    }
}
