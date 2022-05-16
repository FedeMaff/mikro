<?php

/**
 * ConnectionInterface.php
 * Mikro\Common\AMQP\Connection\ConnectionInterface
 *
 * PHP version 7.4
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Common\AMQP\Connection;

/**
 * Interfaccia di gestione connessione AMQP
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
interface ConnectionInterface
{
    /**
     * Metodo di recupero connessione
     *
     * @return Object
     */
    public function getConn(): object;
}
