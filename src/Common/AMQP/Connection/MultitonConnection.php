<?php

/**
 * MultitonConnection.php
 * Mikro\Common\AMQP\Connection\MultitonConnection
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
 * Impelementazione concreta gestione connessione AMQP Multiton
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class MultitonConnection
{
    /**
     * Collezione di istanze di tipo ConnectionInterface
     *
     * @var ConnectionInterface[] $instances array di istanze ConnectionInterface
     */
    private static array $instances = [];

    /**
     * Erogatore di istanza
     *
     * @param string $key Identificativo istanza
     * @param ManagerInterface $manager Istanza gestore di connessione AMQP
     * @param ConfInterface $conf Istanza configurazione
     *
     * @return ConnectionInterface
     */
    public static function getInstance(string $key, ManagerInterface $manager, ConfInterface $conf): ConnectionInterface
    {
        if (!array_key_exists($key, self::$instances)) {
            $class = __CLASS__;
            self::$instances[$key] = $manager($conf);
        }
        return self::$instances[$key];
    }

    /**
     * Eliminazione impostazioni e cancellazione istanza specifica dato identificativo
     *
     * @param string $key Identificativo istanza
     *
     * @return void
     */
    public static function destoryInstance(string $key): void
    {
        $instances = [];
        foreach (self::$instances as $inkey => $value) {
            if ($key == $inkey) {
                continue;
            }
            $instances[$inkey] = $value;
        }
        self::$instances = $instances;
    }

    /**
     * Eliminazione impostazioni e cancellazione di tutte le istanze
     *
     * @return void
     */
    public static function destoryInstances(): void
    {
        self::$instances = [];
    }
}
