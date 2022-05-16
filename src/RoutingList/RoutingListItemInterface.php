<?php

/**
 * RoutingListItemInterface.php
 * Mikro\RoutingList\RoutingListItemInterface
 *
 * PHP version 7.4
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\RoutingList;

use Mikro\ControllerKey\ControllerKeyInterface;

/**
 * Interfaccia mappatura di instradamento
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
interface RoutingListItemInterface
{
    /**
     * Recupero nome classe
     *
     * @return string
     */
    public function getClassName(): string;

    /**
     * Recupero chiave controller
     *
     * @return ControllerKeyInterface
     */
    public function getKey(): ControllerKeyInterface;
}
