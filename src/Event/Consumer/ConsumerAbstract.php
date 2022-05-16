<?php

/**
 * ConsumerAbstract.php
 * Mikro\Event\Consumer\ConsumerAbstract
 *
 * PHP version 7.4
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Event\Consumer;

use Mikro\Event\Consumer\ConsumerInterface;
use Mikro\Common\AMQP\Connection\ConnectionInterface;
use Mikro\Event\EventInterface;

/**
 * Implementazione astratta gestore di ricezione eventi AMQP
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
abstract class ConsumerAbstract implements ConsumerInterface
{
    /**
     * Nome / Chiave di riferimento per la configurazione di connessione
     *
     * Se si sceglie di utilizzare una configurazione di connessione Multiton, è possibile
     * che alcuni Consumer necessitono di parametri di connessione diversi, di conseguenza
     * sarà necessario poter impostare questa preferenza in fase di implementazione concreta
     * del Consumer.
     *
     * @var string $confKey Nome / Chiave preferenza connessione
     */
    protected static $confKey = '';

    /**
     * Istanza connessione AMQP
     *
     * @var ?ConnectionInterface $conn Istanza connessione AMQP
     */
    protected ?ConnectionInterface $conn = null;

    /**
     * Costruttore
     *
     * @param ConnectionInterface $conn Connessione AMQP
     */
    public function __construct(ConnectionInterface $conn)
    {
        $this->conn = $conn;
    }

    /**
     * Recupero statico nome / chiave di riferimento per la configurazione di connessione
     *
     * @return string
     */
    public static function getConfKey(): string
    {
        return static::$confKey;
    }

    /**
     * Attivazione consumo eventi
     *
     * @return void
     */
    abstract public function consume(): void;
}
