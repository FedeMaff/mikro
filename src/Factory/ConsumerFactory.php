<?php

/**
 * ConsumerFactory.php
 * Mikro\Factory\ConsumerFactory
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Factory;

use Mikro\Event\Consumer\ConsumerInterface;
use HaydenPierce\ClassFinder\ClassFinder;
use Mikro\Settings;
use Mikro\Exceptions\NotSetException;
use Mikro\Common\AMQP\Settings as AMQPSettings;
use Mikro\Common\AMQP\Connection\SingletonConnection as SingletonAMQP;
use Mikro\Common\AMQP\Connection\MultitonConnection as MultitonAMQP;

/**
 * Factory di generazione istanze Consumer AMQP
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class ConsumerFactory
{
    /**
     * Generazione istanza ConsumerInterface
     *
     * @param string $name Nome consumer Case Insensitive
     *
     * @return ?ConsumerInterface
     */
    public static function create(string $name): ?ConsumerInterface
    {
        $consumers = self::getConsumersList();
        $consumer = null;
        if (isset($consumers[strtolower($name)])) {
            $managerClassName = AMQPSettings::getManagerClassName();
            if (is_null($managerClassName) || !class_exists($managerClassName)) {
                self::throwManagerNotSetException();
            }
            $manager = new $managerClassName();
            $className = $consumers[strtolower($name)];
            $confKey = $className::getConfKey();
            $conf = AMQPSettings::getConf($confKey);
            if (is_null($conf)) {
                self::throwNotSetException($confKey);
            }
            $conn = empty($confKey)
                  ? SingletonAMQP::getInstance($manager, $conf)
                  : MultitonAMQP::getInstance($confKey, $manager, $conf);
            $consumer = new $consumers[strtolower($name)]($conn);
        }
        return $consumer;
    }

    /**
     * Creazione lista di istanze ConsumerInterface
     *
     * @return array
     */
    private static function getConsumersList(): array
    {
        $nameSpaces = Settings::getConsumersNameSpaces();

        $cache = Settings::getCache();
        if (is_null($cache)) {
            return self::makeConsumersList($nameSpaces);
        }
        $reference = md5(json_encode($nameSpaces));
        $consumersList = $cache->read($reference);
        if (is_null($consumersList)) {
            $consumersList = self::makeConsumersList($nameSpaces);
            $cache->write($reference, serialize($consumersList));
            return $consumersList;
        }
        return unserialize($consumersList);
    }

    /**
     * Costruzione lista di nomi di classi concrete di consumer
     *
     * @param array $nameSpaces Elenco di namespace in cui sono posizionate sotto-classi ConsumerInterface
     *
     * @return array
     */
    private static function makeConsumersList(array $nameSpaces = []): array
    {
        $list = [];
        foreach ($nameSpaces as $nameSpace) {
            $classes = ClassFinder::getClassesInNamespace($nameSpace, ClassFinder::RECURSIVE_MODE);
            foreach ($classes as $className) {
                $interfaces = class_implements($className);
                if (!in_array('Mikro\Event\Consumer\ConsumerInterface', $interfaces)) {
                    continue;
                }
                $pieces = explode('\\', $className);
                $consumer = end($pieces);
                $list[strtolower($consumer)] = $className;
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
        $message[] = 'configurazioni. La chiave di configurazione suggerita dal "consumer" e\'';
        $message[] = empty($confKey) ? 'una stringa vuota.' : sprintf('"%s".', $confKey);
        $message = implode(' ', $message);
        throw new NotSetException($message);
    }
}
