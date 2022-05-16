<?php

/**
 * ConnectionInterface.php
 * Mikro\Common\SQL\Connection\ConnectionInterface
 *
 * PHP version 7.4
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Common\SQL\Connection;

use PDO;

/**
 * Interfaccia di gestione connessione PDO
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
     * @return PDO
     */
    public function getConn(): PDO;
}
