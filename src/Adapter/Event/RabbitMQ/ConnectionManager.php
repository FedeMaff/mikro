<?php

/**
 * ConnectionManager.php
 * Mikro\Adapter\Event\RabbitMQ\ConnectionManager
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Adapter\Event\RabbitMQ;

use Mikro\Common\AMQP\Connection\Manager\ManagerInterface;
use Mikro\Common\AMQP\Connection\ConnectionInterface;
use Mikro\Common\AMQP\Configuration\ConfInterface;
use Mikro\Adapter\Event\RabbitMQ\Connection;

/**
 * Implementazioni istanza di gestione connessione AMQP
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class ConnectionManager implements ManagerInterface
{
    /**
     * Metodo callable che gestisce la configurazione in ingresso istanziando
     * un'entità concreta che implementa le specifiche dell'interfaccia ConnectionInterface.
     *
     * @param ConfInterface $conf Configurazione connessione AMQP
     *
     * @return ConnectionInterface
     */
    public function __invoke(ConfInterface $conf): ConnectionInterface
    {
        return new Connection($conf);
    }
}
