<?php

/**
 * PublisherFactory.php
 * Mikro\Factory\PublisherFactory
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Factory;

use Mikro\Event\Publisher\PublisherInterface;
use HaydenPierce\ClassFinder\ClassFinder;
use Mikro\Settings;
use Mikro\Exceptions\NotSetException;
use Mikro\Common\AMQP\Settings as AMQPSettings;
use Mikro\Common\AMQP\Connection\SingletonConnection as SingletonAMQP;
use Mikro\Common\AMQP\Connection\MultitonConnection as MultitonAMQP;

/**
 * Factory di generazione istanze Publisher AMQP
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class PublisherFactory
{
    /**
     * Generazione istanza PublisherInterface
     *
     * @param string $name Nome publisher Case Insensitive
     *
     * @return ?PublisherInterface
     */
    public static function create(string $name): ?PublisherInterface
    {
        $publishers = self::getPublishersList();
        $publisher = null;
        if (isset($publishers[strtolower($name)])) {
            $managerClassName = AMQPSettings::getManagerClassName();
            if (is_null($managerClassName) || !class_exists($managerClassName)) {
                self::throwManagerNotSetException();
            }
            $manager = new $managerClassName();
            $className = $publishers[strtolower($name)];
            $confKey = $className::getConfKey();
            $conf = AMQPSettings::getConf($confKey);
            if (is_null($conf)) {
                self::throwNotSetException($confKey);
            }
            $conn = empty($confKey)
                  ? SingletonAMQP::getInstance($manager, $conf)
                  : MultitonAMQP::getInstance($confKey, $manager, $conf);
            $publisher = new $publishers[strtolower($name)]($conn);
        }
        return $publisher;
    }

    /**
     * Creazione lista di istanze PublisherInterface
     *
     * @return array
     */
    private static function getPublishersList(): array
    {
        $nameSpaces = Settings::getPublishersNameSpaces();

        $cache = Settings::getCache();
        if (is_null($cache)) {
            return self::makePublishersList($nameSpaces);
        }
        $reference = md5(json_encode($nameSpaces));
        $publishersList = $cache->read($reference);
        if (is_null($publishersList)) {
            $publishersList = self::makePublishersList($nameSpaces);
            $cache->write($reference, serialize($publishersList));
            return $publishersList;
        }
        return unserialize($publishersList);
    }

    /**
     * Costruzione lista di nomi di classi concrete di publisher
     *
     * @param array $nameSpaces Elenco di namespace in cui sono posizionate sotto-classi PublisherInterface
     *
     * @return array
     */
    private static function makePublishersList(array $nameSpaces = []): array
    {
        $list = [];
        foreach ($nameSpaces as $nameSpace) {
            $classes = ClassFinder::getClassesInNamespace($nameSpace, ClassFinder::RECURSIVE_MODE);
            foreach ($classes as $className) {
                $interfaces = class_implements($className);
                if (!in_array('Mikro\Event\Publisher\PublisherInterface', $interfaces)) {
                    continue;
                }
                $pieces = explode('\\', $className);
                $publisher = end($pieces);
                $list[strtolower($publisher)] = $className;
            }
        }
        return $list;
    }

    /**
     * Avvio eccezione NotSetException
     *
     * @param ?string $managerClassName Nome classe concreta Manager
     *
     * @return void
     */
    private static function throwManagerNotSetException(?string $managerClassName): void
    {
        $message[] = 'Nel tentativo di costruire una connessione AMQP non è stato possibile';
        $message[] = 'ottenere un istanza "Manager" valida.';
        $message[] = 'E\' possibile impostare il nome di una classe Manager con il metodo statico';
        $message[] = '"setManagerClassName" del componente Mikro\Common\AMQP\Settings.';

        if (!is_null($managerClassName) && !empty($managerClassName)) {
            $message[] = 'Attualmente la prorpieta\' "managerClassName" e\' stata volorizzata con';
            $message[] = sprintf('la stringa: %s', $managerClassName);
        }

        $message = implode(' ', $message);
        throw new NotSetException($message);
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
        $message[] = 'Nel tentativo di costruire una connessione AMQP non è stato possibile';
        $message[] = 'ottenere una configurazione valida dal sistema statico di gestione delle';
        $message[] = 'configurazioni. La chiave di configurazione suggerita dal "publisher" e\'';
        $message[] = empty($confKey) ? 'una stringa vuota.' : sprintf('"%s".', $confKey);
        $message = implode(' ', $message);
        throw new NotSetException($message);
    }
}
