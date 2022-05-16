<?php

/**
 * ConnectionInterface.php
 * Mikro\Common\AMQP\Connection\Manager\ManagerInterface
 *
 * PHP version 7.4
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Common\AMQP\Connection\Manager;

use Mikro\Common\AMQP\Configuration\ConfInterface;
use Mikro\Common\AMQP\Connection\ConnectionInterface;

/**
 * Interfaccia gestore di connessione AMQP
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
interface ManagerInterface
{
    /**
     * Metodo callable che gestisce la configurazione in ingresso istanziando
     * un'entità concreta che implementa le specifiche dell'interfaccia ConnectionInterface.
     *
     * @param ConfInterface $conf Configurazione connessione AMQP
     *
     * @return ConnectionInterface
     */
    public function __invoke(ConfInterface $conf): ConnectionInterface;
}
