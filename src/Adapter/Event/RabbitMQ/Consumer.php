<?php

/**
 * Consumer.php
 * Mikro\Adapter\Event\RabbitMQ\Consumer
 *
 * PHP version 7.4
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Adapter\Event\RabbitMQ;

use Mikro\Event\Consumer\ConsumerAbstract;
use Mikro\Common\AMQP\Connection\ConnectionInterface;
use Mikro\Event\InboundEventJson as EventJson;
use Mikro\Settings;
use Mikro\Factory\ControllerFactory;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Implementazione astratta gestore di ricezione eventi AMQP RabbitMQ
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
abstract class Consumer extends ConsumerAbstract
{
    /**
     * Nome coda
     * RabbitMQ permette di fare il bind di uno o più exchange
     * su una coda con nome specifico. Questa proprietà è il
     * nome di riferimento della coda di consumo.
     *
     * @var ?string $queueName Nome coda
     */
    protected ?string $queueName = null;

    /**
     * Costruttore
     *
     * N.B. Questa istanza è soggetta alla fattorizzazione, pertanto è bene che
     * l'implementazione concreta esponga un costruttore che non abbia necessità
     * di dover acquisire il "queueName". L'architettura prevede che il "queueName"
     * sia staticizzato nell'implementazione concreta che verrà realizzata; e quindi
     * omesso dal costruttore concreto.
     *
     * @param string $queueName Nome coda oggetto di "consumer"
     */
    public function __construct(ConnectionInterface $conn, string $queueName)
    {
        $this->queueName = sprintf('%s.%s', Settings::getServiceName(), $queueName);
        parent::__construct($conn);
    }

    /**
     * Metodo callable di callback
     *
     * @param AMQPMessage $message Messaggio AMQP
     *
     * @return void
     */
    public function __invoke(AMQPMessage $message): void
    {
        $event = new EventJson($message->body);
        try {
            ControllerFactory::create($event)->run();
            $message->ack();
        } catch (\Exception $e) {
            unset($e);
            $message->nack();
        }
    }

    /**
     * Attivazione consumo eventi
     *
     * @return void
     */
    public function consume(): void
    {
        $connection = $this->conn->getConn();
        $channel = $connection->channel();
        $this->channelSettings($channel);
        $channel->basic_consume($this->queueName, '', false, false, false, false, $this);
        while ($channel->is_open()) {
            $channel->wait();
        }
    }

    /**
     * Configurazione regole di consumo RabbitMQ
     * Assegnazione dichiarazioni exchange, queue e binding
     *
     * @param AMQPChannel $channel Canael RabbitMQ
     *
     * @return void
     */
    abstract protected function channelSettings(AMQPChannel $channel): void;
}
