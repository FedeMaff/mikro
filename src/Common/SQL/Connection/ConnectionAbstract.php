<?php

/**
 * ConnectionAbstract.php
 * Mikro\Common\SQL\Connection\ConnectionAbstract
 *
 * PHP version 7.4
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Common\SQL\Connection;

use Mikro\Common\SQL\Connection\ConnectionInterface;
use Mikro\Common\SQL\Configuration\ConfInterface;
use Mikro\Common\SQL\Exceptions\SQLConnectionException;
use PDO;

/**
 * Impelementazione astratta di gestione connessione PDO
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
abstract class ConnectionAbstract implements ConnectionInterface
{
    /**
     * Istanza connessione PDO
     *
     * @var ?PDO $conn Istanza connessione PDO
     */
    private ?PDO $conn = null;

    /**
     * Istanza di configurazione connessione SQL
     *
     * @var ?ConfInterface $conf Istanza di configurazione connessione SQL
     */
    private ?ConfInterface $conf = null;

    /**
     * Costrutture
     *
     * @param ConfInterface $conf Istanza di configurazione connessione SQL
     */
    public function __construct(ConfInterface $conf)
    {
        $this->conf = $conf;
    }

    /**
     * Metodo di recupero connessione
     *
     * @return PDO
     */
    public function getConn(): PDO
    {
        if (is_null($this->conn) || !$this->connIsActive()) {
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
        $conf = $this->conf;
        $host = $conf->getHost();
        $port = $conf->getPort();
        $user = is_null($conf->getUsername()) ? '' : $conf->getUsername();
        $pass = is_null($conf->getPassword()) ? '' : $conf->getPassword();
        $dbname = $conf->getDatabase();

        if (is_null($host) || empty($host)) {
            $this->throwSQLConnectionExceptionHostNotSet($user, $port);
        }

        if (is_null($port) || empty($port)) {
            $this->throwSQLConnectionExceptionPortNotSet($host, $user);
        }

        try {
            if (is_null($dbname)) {
                $string = 'mysql:host=%s;port=%s;charset=%s;';
                $dsn = sprintf($string, $host, $port, 'utf8');
            } else {
                $string = 'mysql:host=%s;port=%s;dbname=%s;charset=%s;';
                $dsn = sprintf($string, $host, $port, $dbname, 'utf8');
            }
            $this->conn = new \PDO($dsn, $user, $pass, [\PDO::ATTR_TIMEOUT => 5]);
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\Exception $e) {
            $exception = new SQLConnectionException($e->getMessage());
            $exception->setHost($host);
            $exception->setPort($port);
            $exception->setUsername($user);
            throw $exception;
        }
    }

    /**
     * Verifica stato connessione PDO
     *
     * @return bool
     */
    private function connIsActive(): bool
    {
        if (is_null($this->conn)) {
            return false;
        }
        try {
            $this->conn->query("SELECT 1");
            return true;
        } catch (\Exception $e) {
            unset($e);
        }
        return false;
    }

    /**
     * Avvio eccezione SQLConnectionException dovuta ad assenza di
     * parametrizzazione dell'host / ip
     *
     * @param string $username Nome utente utilizzato per la connessione
     * @param ?int $port Numero porta utilizzata per la connessione
     *
     * @return void
     */
    private function throwSQLConnectionExceptionHostNotSet(string $username, ?int $port = null): void
    {
        $message[] = 'Tentativo di connessione SQL interrotto il parametro';
        $message[] = '"host" dell\'oggetto di configurazione e\' nullo o vuoto';
        $message = implode(' ', $message);
        $exception = new SQLConnectionException($message);
        $exception->setUsername($username);
        if (!is_null($port)) {
            $exception->setPort($port);
        }
        throw $exception;
    }

    /**
     * Avvio eccezione SQLConnectionException dovuta ad assenza di
     * parametrizzazione della porta
     *
     * @param string $host Nome host / ip
     * @param string $username Nome utente utilizzato per la connessione
     *
     * @return void
     */
    private function throwSQLConnectionExceptionPortNotSet(string $host, string $username): void
    {
        $message[] = 'Tentativo di connessione SQL interrotto il parametro';
        $message[] = '"port" dell\'oggetto di configurazione e\' nullo o uguale a 0';
        $message = implode(' ', $message);
        $exception = new SQLConnectionException($message);
        $exception->setHost($host);
        $exception->setUsername($username);
        throw $exception;
    }
}
