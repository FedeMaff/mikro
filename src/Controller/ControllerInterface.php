<?php

/**
 * ControllerInterface.php
 * Mikro\Controller\ControllerInterface
 *
 * PHP version 7.4
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Controller;

use Mikro\Request\RequestInterface;

/**
 * Interfaccia generica controller
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
interface ControllerInterface
{
    /**
     * Assegnazione richiesta
     *
     * @var RequestInterface $request Istanza RequestInterface
     */
    public function setRequest(RequestInterface $request): void;
}
