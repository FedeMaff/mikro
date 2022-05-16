<?php

/**
 * Settings.php
 * Mikro\Common\AMQP\Settings
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Common\AMQP;

use Mikro\Common\AMQP\Configuration\ConfInterface;
use Mikro\Common\AMQP\Configuration\Conf;
use Mikro\Common\AMQP\Connection\Manager\ManagerInterface;

/**
 * Implementazione concreta gestore di configurazioni AMQP
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class Settings
{
    /**
     * Percorso implementazione concreta ManagerInterface
     *
     * @var ?string $managerClassName Percorso implementazione concreta ManagerInterface
     */
    private static ?string $managerClassName = null;

    /**
     * Istanza di configurazione connessione
     *
     * @var ?ConfInterface $configuration Istanza Conf
     */
    private static ?ConfInterface $configuration = null;

    /**
     * Collezione di configurazioni di connessione
     *
     * @var ConfInterface[] $configuration Collezione di istanze Conf
     */
    private static array $configurations = [];

    /**
     * Assegnazione percorso implementazione concreta ManagerInterface
     *
     * @param ?string $managerClassName Percorso implementazione concreta ManagerInterface
     *
     * @return void
     */
    public static function setManagerClassName(?string $managerClassName = null): void
    {
        self::$managerClassName = $managerClassName;
    }

    /**
     * Recupero percorso implementazione concreta ManagerInterface
     *
     * @return ?string
     */
    public static function getManagerClassName(): ?string
    {
        return self::$managerClassName;
    }

    /**
     * Assegnazione istanza di configurazione ConfInterface
     *
     * @param ConfInterface $conf Istanza configurazione connessione
     * @param string $key Chiave identificativa configurazione
     *
     * @return void
     */
    public static function setConf(ConfInterface $conf, string $key = ''): void
    {
        if (empty($key)) {
            self::$configuration = $conf;
            return;
        }
        self::$configurations[$key] = $conf;
    }

    /**
     * Recupero istanza di configurazione ConfInterface
     *
     * Questo metodo recupera un'istanza ConfInterface in 2 modi:
     *
     * 1) Se il parametro $key non è valorizzato questa classe restituisce la
     * proprietà statica self::$configuration
     *
     * 2) Se il parametro $key è valorizzato con una stringa di identificazione
     * questo metodo restituisce l'istanza ConfInterface con chiave $key presente
     * nell'array statico $configurations. In caso non sia presente l'indice $key
     * questo metodo restituisce null.
     *
     * @param string $key Chiave identificativa configurazione
     *
     * @return ?ConfInterface
     */
    public static function getConf(string $key = ''): ?ConfInterface
    {
        if (empty($key)) {
            return self::$configuration;
        }
        return array_key_exists($key, self::$configurations) ? self::$configurations[$key] : null;
    }

    /**
     * Recupero host / ip
     *
     * @param string $host Host / ip
     *
     * @return void
     */
    public static function setHost(string $host): void
    {
        self::getConfInstance()->setHost($host);
    }

    /**
     * Recupero porta
     *
     * @param int $port Porta
     *
     * @return void
     */
    public static function setPort(int $port): void
    {
        self::getConfInstance()->setPort($port);
    }

    /**
     * Recupero nome utente
     *
     * @param string $username Nome utente
     *
     * @return void
     */
    public static function setUsername(string $username): void
    {
        self::getConfInstance()->setUsername($username);
    }

    /**
     * Recupero password
     *
     * @param string $password Password
     *
     * @return void
     */
    public static function setPassword(string $password): void
    {
        self::getConfInstance()->setPassword($password);
    }

    /**
     * Recupero istanza ConfInterface statica
     * Questo metodo restituisce un istanza di ConfInterface recuperandola dalla
     * proprietà statica self::$configuration. Se l'istanza statica non è disponibile
     * viene creata una nuova istanza e salvata nella proprietà statica di questa
     * classe di configurazione.
     *
     * @return ConfInterface
     */
    private static function getConfInstance(): ConfInterface
    {
        if (is_null(self::$configuration)) {
            self::$configuration = new Conf();
        }
        return self::$configuration;
    }
}
