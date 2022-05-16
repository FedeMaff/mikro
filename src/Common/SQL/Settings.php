<?php

/**
 * Settings.php
 * Mikro\Common\SQL\Settings
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Common\SQL;

use Mikro\Common\SQL\Configuration\ConfInterface;
use Mikro\Common\SQL\Configuration\Conf;

/**
 * Implementazione concreta gestore di configurazioni SQL
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class Settings
{
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
     * Assegnazione istanza di configurazione ConfInterface
     *
     * @param ConfInterface $conf Istanza configurazione connessione SQL
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
     * Recupero nome database
     *
     * @param string $database Nome database
     *
     * @return void
     */
    public static function setDatabase(string $database): void
    {
        self::getConfInstance()->setDatabase($database);
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
