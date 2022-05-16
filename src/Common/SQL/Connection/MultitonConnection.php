<?php

/**
 * MultitonConnection.php
 * Mikro\Common\SQL\Connection\MultitonConnection
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
 * Impelementazione concreta di gestione connessione SQL Multiton
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class MultitonConnection extends ConnectionAbstract
{
    /**
     * Collezione di istanze di tipo ConnectionInterface
     *
     * @var ConnectionInterface[] $instances array di istanze ConnectionInterface
     */
    private static array $instances = [];

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
     * @param string $key Identificativo istanza
     * @param ConfInterface $conf Istanza configurazione
     *
     * @return ConnectionInterface
     */
    public static function getInstance(string $key, ConfInterface $conf): ConnectionInterface
    {
        if (!array_key_exists($key, self::$instances)) {
            $class = __CLASS__;
            self::$instances[$key] = new $class($config);
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
