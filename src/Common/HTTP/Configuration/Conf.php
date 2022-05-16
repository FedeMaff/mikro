<?php

/**
 * Conf.php
 * Mikro\Common\HTTP\Configuration\Conf
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Common\HTTP\Configuration;

use Mikro\Common\HTTP\Configuration\ConfInterface;

/**
 * Implementazione concreta configurazione connessione HTTP
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
     * Costrutture
     *
     * @param string $host Host / Ip
     * @param int $port Porta
     * @param ?string $username Nome utente
     * @param ?string $password Password
     */
    public function __construct(
        ?string $host = null,
        ?int $port = null
    ) {
        $this->host = $host;
        $this->port = $port;
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
}
