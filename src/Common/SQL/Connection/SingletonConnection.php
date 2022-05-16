<?php

/**
 * SingletonConnection.php
 * Mikro\Common\SQL\Connection\SingletonConnection
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Common\SQL\Connection;

use Mikro\Common\SQL\Connection\ConnectionInterface;
use Mikro\Common\SQL\Connection\ConnectionAbstract;
use Mikro\Common\SQL\Configuration\ConfInterface;

/**
 * Impelementazione concreta di gestione connessione SQL Singleton
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class SingletonConnection extends ConnectionAbstract
{
    /**
     * Istanza di tipo ConnectionInterface
     *
     * @var ?ConnectionInterface $instance Istanza ConnectionInterface
     */
    private static ?ConnectionInterface $instance = null;

    /**
     * Costrutture
     *
     * @param ConfInterface $conf Istanza di configurazione connessione SQL
     *
     * @return void
     */
    private function __construct(ConfInterface $conf)
    {
        parent::__construct($conf);
    }

    /**
     * Erogatore di istanza
     *
     * @param ConfInterface $conf Istanza configurazione
     *
     * @return ConnectionInterface
     */
    public static function getInstance(ConfInterface $conf): ConnectionInterface
    {
        if (is_null(self::$instance)) {
            $class = __CLASS__;
            self::$instance = new $class($conf);
        }
        return self::$instance;
    }

    /**
     * Eliminazione impostazioni e cancellazione istanza
     *
     * @return void
     */
    public static function destoryInstance(): void
    {
        self::$instance = null;
    }
}
