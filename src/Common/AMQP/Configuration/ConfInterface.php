<?php

/**
 * ConfInterface.php
 * Mikro\Common\AMQP\Configuration\ConfInterface
 *
 * PHP version 7.4
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Common\AMQP\Configuration;

/**
 * Interfaccia configurazione connessione AMQP
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
interface ConfInterface
{
    /**
     * Recupero host / ip
     *
     * @return ?string
     */
    public function getHost(): ?string;

    /**
     * Recupero porta
     *
     * @return ?int
     */
    public function getPort(): ?int;

    /**
     * Recupero nome utente
     *
     * @return ?string
     */
    public function getUsername(): ?string;

    /**
     * Recupero password
     *
     * @return ?string
     */
    public function getPassword(): ?string;
}
