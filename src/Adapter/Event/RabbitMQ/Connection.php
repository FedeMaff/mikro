<?php

/**
 * Connection.php
 * Mikro\Adapter\Event\RabbitMQ\Connection
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Adapter\Event\RabbitMQ;

use Mikro\Common\AMQP\Connection\ConnectionInterface;
use Mikro\Common\AMQP\Configuration\ConfInterface;
use Mikro\Common\AMQP\Exceptions\AMQPConnectionException;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exception\AMQPRuntimeException;
use PhpAmqpLib\Exception\AMQPConnectionClosedException;
use PhpAmqpLib\Exception\AMQPIOException;
use RuntimeException;
use ErrorException;

/**
 * Implementazioni istanza di connessione
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class Connection implements ConnectionInterface
{
    /**
     * Istanza connessione AMQP
     *
     * @var ?ConfInterface $conf Istanza configurazione connessione AMQP
     */
    private ?ConfInterface $conf = null;

    /**
     * Istanza connessione AMQP
     *
     * @var ?AMQPStreamConnection $conn Istanza connessione AMQP
     */
    private ?AMQPStreamConnection $conn = null;

    /**
     * Costruttore
     *
     * @param AMQPStreamConnection $conf Istanza configurazione connessione AMQP
     */
    public function __construct(ConfInterface $conf)
    {
        $this->conf = $conf;
    }

    /**
     * Metodo di recupero connessione
     *
     * @return Object
     */
    public function getConn(): object
    {
        if (is_null($this->conn) || !$this->conn->isConnected()) {
            $this->conn = null;
            $this->makeConn();
        }
        return $this->conn;
    }

    /**
     * Metodo di creazione connessione
     *
     * @return void
     */
    private function makeConn(): void
    {
        $host = $this->conf->getHost();
        $port = $this->conf->getPort();
        $user = $this->conf->getUsername();
        $user = is_null($user) ? '' : $user;
        $pass = $this->conf->getPassword();
        $pass = is_null($pass) ? '' : $pass;

        if (is_null($host) || empty($host)) {
            $this->throwAMQPConnectionExceptionHostNotSet($user, $port);
        }

        if (is_null($port) || empty($port)) {
            $this->throwAMQPConnectionExceptionPortNotSet($host, $user);
        }

        try {
            $this->conn = new AMQPStreamConnection($host, $port, $user, $pass);
        } catch (AMQPRuntimeException $e) {
            $this->throwAMQPRuntimeException($e);
        } catch (AMQPConnectionClosedException $e) {
            $this->throwAMQPConnectionClosedException($e);
        } catch (AMQPIOException $e) {
            $this->throwAMQPIOException($e);
        } catch (RuntimeException $e) {
            $this->throwRuntimeException($e);
        } catch (ErrorException $e) {
            $this->throwErrorException($e);
        }
    }

    /**
     * Avvio eccezione AMQPConnectionException dovuta ad assenza di
     * parametrizzazione dell'host / ip
     *
     * @param string $username Nome utente utilizzato per la connessione
     * @param ?int $port Numero porta utilizzata per la connessione
     *
     * @return void
     */
    private function throwAMQPConnectionExceptionHostNotSet(string $username, ?int $port = null): void
    {
        $message[] = 'Tentativo di connessione AMQP interrotto il parametro';
        $message[] = '"host" dell\'oggetto di configurazione e\' nullo o vuoto';
        $message = implode(' ', $message);
        $exception = new AMQPConnectionException($message);
        $exception->setUsername($username);
        if (!is_null($port)) {
            $exception->setPort($port);
        }
        throw $exception;
    }

    /**
     * Avvio eccezione AMQPConnectionException dovuta ad assenza di
     * parametrizzazione della porta
     *
     * @param string $host Nome host / ip
     * @param string $username Nome utente utilizzato per la connessione
     *
     * @return void
     */
    private function throwAMQPConnectionExceptionPortNotSet(string $host, string $username): void
    {
        $message[] = 'Tentativo di connessione AMQP interrotto il parametro';
        $message[] = '"port" dell\'oggetto di configurazione e\' nullo o uguale a 0';
        $message = implode(' ', $message);
        $exception = new AMQPConnectionException($message);
        $exception->setHost($host);
        $exception->setUsername($username);
        throw $exception;
    }

    /**
     * Avvio eccezione AMQPRuntimeException
     *
     * @param AMQPRuntimeException $e eccezione
     *
     * @return void
     */
    private function throwAMQPRuntimeException(AMQPRuntimeException $e): void
    {
        $message[] = 'La connessione AMQP e\' stata interrotta a runtime ( amqp ) inaspettatamente:';
        $message[] = $e->getMessage();
        $message = implode(' ', $message);
        $exception = new AMQPConnectionException($message);
        $exception->setHost($this->conf->getHost());
        $exception->setPort($this->conf->getPort());
        $exception->setUsername($this->conf->getUsername());
        throw $exception;
    }

    /**
     * Avvio eccezione AMQPConnectionClosedException
     *
     * @param AMQPConnectionClosedException $e eccezione
     *
     * @return void
     */
    private function throwAMQPConnectionClosedException(AMQPConnectionClosedException $e): void
    {
        $message[] = 'La connessione AMQP e\' stata chiusa inaspettatamente:';
        $message[] = $e->getMessage();
        $message = implode(' ', $message);
        $exception = new AMQPConnectionException($message);
        $exception->setHost($this->conf->getHost());
        $exception->setPort($this->conf->getPort());
        $exception->setUsername($this->conf->getUsername());
        throw $exception;
    }

    /**
     * Avvio eccezione AMQPIOException
     *
     * @param AMQPIOException $e eccezione
     *
     * @return void
     */
    private function throwAMQPIOException(AMQPIOException $e): void
    {
        $message[] = 'La connessione AMQP e\' stata interrotta a causa di una';
        $message[] = 'eccezione di tipo IO:';
        $message[] = $e->getMessage();
        $message = implode(' ', $message);
        $exception = new AMQPConnectionException($message);
        $exception->setHost($this->conf->getHost());
        $exception->setPort($this->conf->getPort());
        $exception->setUsername($this->conf->getUsername());
        throw $exception;
    }

    /**
     * Avvio eccezione RuntimeException
     *
     * @param RuntimeException $e eccezione
     *
     * @return void
     */
    private function throwRuntimeException(RuntimeException $e): void
    {
        $message[] = 'La connessione AMQP e\' stata interrotta a runtime inaspettatamente:';
        $message[] = $e->getMessage();
        $message = implode(' ', $message);
        $exception = new AMQPConnectionException($message);
        $exception->setHost($this->conf->getHost());
        $exception->setPort($this->conf->getPort());
        $exception->setUsername($this->conf->getUsername());
        throw $exception;
    }

    /**
     * Avvio eccezione ErrorException
     *
     * @param ErrorException $e eccezione
     *
     * @return void
     */
    private function throwErrorException(ErrorException $e): void
    {
        $message[] = 'La connessione AMQP e\' stata interrotta inaspettatamente:';
        $message[] = $e->getMessage();
        $message = implode(' ', $message);
        $exception = new AMQPConnectionException($message);
        $exception->setHost($this->conf->getHost());
        $exception->setPort($this->conf->getPort());
        $exception->setUsername($this->conf->getUsername());
        throw $exception;
    }
}
