<?php

/**
 * ConsumerInterface.php
 * Mikro\Event\Consumer\ConsumerInterface
 *
 * PHP version 7.4
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Event\Consumer;

/**
 * Interfaccia gestore di ricezione eventi
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
interface ConsumerInterface
{
    /**
     * Attivazione consumo eventi
     *
     * @return void
     */
    public function consume(): void;
}
