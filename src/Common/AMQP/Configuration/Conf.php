<?php

/**
 * Conf.php
 * Mikro\Common\AMQP\Configuration\Conf
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Common\AMQP\Configuration;

use Mikro\Common\AMQP\Configuration\ConfInterface;

/**
 * Implementazione concreta configurazione connessione AMQP
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class Conf implements ConfInterface
{
    /**
     * Host / Ip
     *
     * @var ?string $host Host / Ip
     */
    private ?string $host = null;

    /**
     * Porta
     *
     * @var ?int $port Porta
     */
    private ?int $port = null;

    /**
     * Nome utente
     *
     * @var ?string $username Nome utente
     */
    private ?string $username = null;

    /**
     * Password
     *
     * @var ?string $password Password
     */
    private ?string $password = null;

    /**
     * Costrutture
     *
     * @param string $host Host / Ip
     * @param int $port Porta
     * @param ?string $username Nome utente
     * @param ?string $password Password
     */
    public function __construct(
        ?string $host = null,
        ?int $port = null,
        ?string $username = null,
        ?string $password = null
    ) {
        $this->host = $host;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Recupero host / ip
     *
     * @param string $host Host / ip
     *
     * @return void
     */
    public function setHost(string $host): void
    {
        $this->host = $host;
    }

    /**
     * Recupero porta
     *
     * @param int $port Porta
     *
     * @return void
     */
    public function setPort(int $port): void
    {
        $this->port = $port;
    }

    /**
     * Recupero nome utente
     *
     * @param string $username Nome utente
     *
     * @return void
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * Recupero password
     *
     * @param string $password Password
     *
     * @return void
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * Recupero host / ip
     *
     * @return ?string
     */
    public function getHost(): ?string
    {
        return $this->host;
    }

    /**
     * Recupero porta
     *
     * @return ?int
     */
    public function getPort(): ?int
    {
        return $this->port;
    }

    /**
     * Recupero nome utente
     *
     * @return ?string
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * Recupero password
     *
     * @return ?string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }
}
