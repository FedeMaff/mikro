<?php

/**
 * RoutingManagerInterface.php
 * Mikro\RoutingManager\RoutingManagerInterface
 *
 * PHP version 7.4
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\RoutingManager;

use Mikro\Controller\ControllerInterface;

/**
 * Interfaccia gestore di instradamento
 * Quesato componente architetturale eseguira in modo concreto il match tra
 * la richiesta e le chiavi di instradamento mappate in una RoutingList.
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
interface RoutingManagerInterface
{
    /**
     * Recupero istanza Controller
     *
     * @return ?ControllerInterface
     */
    public function getController(): ?ControllerInterface;
}
