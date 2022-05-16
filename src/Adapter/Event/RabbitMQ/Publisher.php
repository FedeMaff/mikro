<?php

/**
 * Publisher.php
 * Mikro\Adapter\Event\RabbitMQ\Publisher
 *
 * PHP version 7.4
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Adapter\Event\RabbitMQ;

use Mikro\Event\Publisher\PublisherAbstract;
use Mikro\Common\AMQP\Connection\ConnectionInterface;
use Mikro\Event\EventInterface;
use Mikro\Settings;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Implementazione astratta gestore di inoltro eventi AMQP RabbitMQ
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
abstract class Publisher extends PublisherAbstract
{
    /**
     * Nome exchange
     * RabbitMQ permette di inviare messaggi ad uno specifico
     * exchange. Per fare questo è necessario dichiararlo e decorare
     * la dichiarazione con diverse proprietà. Queste proprietà sono
     * a carico dell'implementazione concreta che di volta in volta
     * potrà scegliere quale tipo di exchange è più appropriato.
     * La definizione del nome dell'exchange è essenziale per mascherare
     * all'implementazione concreta la funzionalità di pubblicazione
     * implementata in questa classe nel metodo publish().
     *
     * @var ?string $exchangeName Nome exchange
     */
    protected ?string $exchangeName = null;

    /**
     * Costruttore
     *
     * N.B. Questa istanza è soggetta alla fattorizzazione, pertanto è bene che
     * l'implementazione concreta esponga un costruttore che non abbia necessità
     * di dover acquisire l' "exchangeName". L'architettura prevede che l' "exchangeName"
     * sia staticizzato nell'implementazione concreta che verrà realizzata; e quindi
     * omesso dal costruttore concreto.
     *
     * @param ConnectionInterface $conn Connessione AMQP
     * @param string $exchangeName Nome exchange gestore di scambio
     */
    public function __construct(ConnectionInterface $conn, string $exchangeName)
    {
        $this->exchangeName = $exchangeName;
        parent::__construct($conn);
    }

    /**
     * Avvio pubblicazione evento
     *
     * @param EventInterface $event Istanza evento
     *
     * @return void
     */
    public function publish(EventInterface $event): void
    {
        $connection = $this->conn->getConn();
        $channel = $connection->channel();
        $this->channelSettings($channel);
        $data = sprintf($event);
        $message = new AMQPMessage($data);
        $routingKey = sprintf('%s.%s', Settings::getServiceName(), $event->getName());
        $channel->basic_publish($message, $this->exchangeName, $routingKey);
        $channel->close();
        $connection->close();
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
