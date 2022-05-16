<?php

/**
 * RequestInterface.php
 * Mikro\Request\RequestInterface
 *
 * PHP version 7.4
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Request;

/**
 * Interfaccia generica di richiesta
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
interface RequestInterface
{
    /**
     * Recupero parametri di richiesta
     *
     * @return array
     */
    public function getData(): array;
}
