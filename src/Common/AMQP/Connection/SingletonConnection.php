<?php

/**
 * SingletonConnection.php
 * Mikro\Common\AMQP\Connection\SingletonConnection
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Common\AMQP\Connection;

use Mikro\Common\AMQP\Configuration\ConfInterface;
use Mikro\Common\AMQP\Connection\ConnectionInterface;
use Mikro\Common\AMQP\Connection\Manager\ManagerInterface;

/**
 * Impelementazione concreta gestione connessione AMQP Singleton
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class SingletonConnection
{
    /**
     * Istanza di tipo ConnectionInterface
     *
     * @var ?ConnectionInterface $instance Istanza ConnectionInterface
     */
    private static ?ConnectionInterface $instance = null;

    /**
     * Erogatore di istanza
     *
     * @param ManagerInterface $manager Istanza gestore di connessione AMQP
     * @param ConfInterface $conf Istanza configurazione
     *
     * @return ConnectionInterface
     */
    public static function getInstance(ManagerInterface $manager, ConfInterface $conf): ConnectionInterface
    {
        if (is_null(self::$instance)) {
            $class = __CLASS__;
            self::$instance = $manager($conf);
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
