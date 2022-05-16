<?php

/**
 * RepositoryFactory.php
 * Mikro\Factory\RepositoryFactory
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Factory;

use Mikro\Repository\RepositoryInterface;
use HaydenPierce\ClassFinder\ClassFinder;
use Mikro\Settings;
use Mikro\Exceptions\NotSetException;
use Mikro\Common\SQL\Settings as SQLSettings;
use Mikro\Common\SQL\Connection\MultitonConnection as MultitonSQL;
use Mikro\Common\SQL\Connection\SingletonConnection as SingletonSQL;

/**
 * Factory di generazione istanze Repository
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class RepositoryFactory
{
    /**
     * Generazione istanza RepositoryInterface
     *
     * @param string $name Nome repository Case Insensitive
     *
     * @return ?RepositoryInterface
     */
    public static function create(string $name): ?RepositoryInterface
    {
        $repositories = self::getRepositoriesList();
        $repository = null;
        if (isset($repositories[strtolower($name)])) {
            $className = $repositories[strtolower($name)];
            $confKey = $className::getConfKey();
            $conf = SQLSettings::getConf($confKey);
            if (is_null($conf)) {
                self::throwNotSetException($confKey);
            }
            $conn = empty($confKey)
                  ? SingletonSQL::getInstance($conf)
                  : MultitonSQL::getInstance($confKey, $conf);
            $repository = new $repositories[strtolower($name)]($conn);
        }
        return $repository;
    }

    /**
     * Creazione lista di istanze RepositoryInterface
     *
     * @return array
     */
    private static function getRepositoriesList(): array
    {
        $nameSpaces = Settings::getRepositoriesNameSpaces();

        $cache = Settings::getCache();
        if (is_null($cache)) {
            return self::makeRepositoriesList($nameSpaces);
        }
        $reference = md5(json_encode($nameSpaces));
        $repositoriesList = $cache->read($reference);
        if (is_null($repositoriesList)) {
            $repositoriesList = self::makeRepositoriesList($nameSpaces);
            $cache->write($reference, serialize($repositoriesList));
            return $repositoriesList;
        }
        return unserialize($repositoriesList);
    }

    /**
     * Costruzione lista di nomi di classi concrete di repository
     *
     * @param array $nameSpaces Elenco di namespace in cui sono posizionate sotto-classi ModelInterface
     *
     * @return array
     */
    private static function makeRepositoriesList(array $nameSpaces = []): array
    {
        $list = [];
        foreach ($nameSpaces as $nameSpace) {
            $classes = ClassFinder::getClassesInNamespace($nameSpace, ClassFinder::RECURSIVE_MODE);
            foreach ($classes as $className) {
                $interfaces = class_implements($className);
                if (!in_array('Mikro\Repository\RepositoryInterface', $interfaces)) {
                    continue;
                }
                $pieces = explode('\\', $className);
                $repository = end($pieces);
                $list[strtolower($repository)] = $className;
            }
        }
        return $list;
    }

    /**
     * Avvio eccezione NotSetException
     *
     * @param string $confKey Nome identificativo set di configurazione
     *
     * @return void
     */
    private static function throwNotSetException(string $confKey = ''): void
    {
        $message[] = 'Nel tentativo di costruire una connessione SQL non è stato possibile';
        $message[] = 'ottenere una configurazione valida dal sistema statico di gestione delle';
        $message[] = 'configurazioni SQL. La chiave di configurazione suggerita dal repository e\'';
        $message[] = empty($confKey) ? 'una stringa vuota.' : sprintf('"%s".', $confKey);
        $message = implode(' ', $message);
        throw new NotSetException($message);
    }
}
