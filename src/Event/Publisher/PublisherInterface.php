<?php

/**
 * PublisherInterface.php
 * Mikro\Event\Publisher\PublisherInterface
 *
 * PHP version 7.4
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Event\Publisher;

use Mikro\Event\EventInterface;

/**
 * Interfaccia gestore di invio eventi
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
interface PublisherInterface
{
    /**
     * Avvio pubblicazione evento
     *
     * @param EventInterface $event Istanza evento
     *
     * @return void
     */
    public function publish(EventInterface $event): void;
}
