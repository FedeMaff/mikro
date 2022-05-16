<?php

/**
 * ModelFactory.php
 * Mikro\Factory\ModelFactory
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Factory;

use Mikro\Model\ModelInterface;
use Mikro\Repository\RepositoryInterface;
use HaydenPierce\ClassFinder\ClassFinder;
use Mikro\Factory\RepositoryFactory;
use Mikro\Settings;
use Mikro\Exceptions\NotSetException;
use Mikro\Exceptions\NotFoundException;

/**
 * Factory di generazione istanze Modello logica di business generica
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class ModelFactory
{
    /**
     * Generazione istanza ModelInterface
     *
     * @param string $name Nome modello Case Insensitive
     *
     * @return ModelInterface
     */
    public static function create(string $name): ModelInterface
    {
        $models = self::getModelsList();
        if (!isset($models[strtolower($name)])) {
            self::throwNotFoundException($name);
        }

        $repository = RepositoryFactory::create($name);
        return new $models[strtolower($name)]($repository);
    }

    /**
     * Creazione lista di istanze ModelInterface
     *
     * @return array
     */
    private static function getModelsList(): array
    {
        $nameSpaces = Settings::getModelsNameSpaces();
        if (empty($nameSpaces)) {
            self::throwNotSetException();
        }

        $cache = Settings::getCache();
        if (is_null($cache)) {
            return self::makeModelsList($nameSpaces);
        }
        $reference = md5(json_encode($nameSpaces));
        $modelsList = $cache->read($reference);
        if (is_null($modelsList)) {
            $modelsList = self::makeModelsList($nameSpaces);
            $cache->write($reference, serialize($modelsList));
            return $modelsList;
        }
        return unserialize($modelsList);
    }

    /**
     * Costruzione lista di nomi di classi concrete di modelli
     *
     * @param array $nameSpaces Elenco di namespace in cui sono posizionate sotto-classi ModelInterface
     *
     * @return array
     */
    private static function makeModelsList(array $nameSpaces = []): array
    {
        $list = [];
        foreach ($nameSpaces as $nameSpace) {
            $classes = ClassFinder::getClassesInNamespace($nameSpace, ClassFinder::RECURSIVE_MODE);
            foreach ($classes as $className) {
                $interfaces = class_implements($className);
                if (!in_array('Mikro\Model\ModelInterface', $interfaces)) {
                    continue;
                }
                $pieces = explode('\\', $className);
                $model = end($pieces);
                $list[strtolower($model)] = $className;
            }
        }
        return $list;
    }

    /**
     * Avvio eccezione NotSetException
     *
     * @return void
     */
    private static function throwNotSetException(): void
    {
        $message[] = 'La collezione di name space model Settings.modelsNameSpaces';
        $message[] = 'non riporta alcun tipo di name space psr-4. Senza un elenco di percorsi';
        $message[] = 'non e\' possibile identificare alcun modello di business.';
        $message = implode(' ', $message);
        throw new NotSetException($message);
    }

    /**
     * Avvio eccezione NotFoundException
     *
     * @param string $name Nome modello
     *
     * @return void
     */
    private static function throwNotFoundException(string $name): void
    {
        $message[] = 'Non e\' stato trovato nessun modello di business compatibile con la';
        $message[] = sprintf('stringa: %s', $name);
        $message = implode(' ', $message);
        throw new NotFoundException($message);
    }
}
