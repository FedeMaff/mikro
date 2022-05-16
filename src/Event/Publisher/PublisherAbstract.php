<?php

/**
 * PublisherAbstract.php
 * Mikro\Event\Publisher\PublisherAbstract
 *
 * PHP version 7.4
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Event\Publisher;

use Mikro\Event\Publisher\PublisherInterface;
use Mikro\Common\AMQP\Connection\ConnectionInterface;
use Mikro\Event\EventInterface;

/**
 * Implementazione astratta gestore di inoltro eventi AMQP
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
abstract class PublisherAbstract implements PublisherInterface
{
    /**
     * Nome / Chiave di riferimento per la configurazione di connessione
     *
     * Se si sceglie di utilizzare una configurazione di connessione Multiton, è possibile
     * che alcuni publisher necessitono di parametri di connessione diversi, di conseguenza
     * sarà necessario poter impostare questa preferenza in fase di implementazione concreta
     * del publisher.
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
     * Avvio pubblicazione evento
     *
     * @param EventInterface $event Istanza evento
     *
     * @return void
     */
    abstract public function publish(EventInterface $event): void;
}
