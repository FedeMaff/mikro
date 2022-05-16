<?php

/**
 * RoutingListFactory.php
 * Mikro\Factory\RoutingListFactory
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Factory;

use Mikro\RoutingList\RoutingListInterface;
use Mikro\RoutingList\RoutingList;
use Mikro\Factory\RoutingListItemFactory;
use HaydenPierce\ClassFinder\ClassFinder;
use Mikro\Settings;

/**
 * Factory di generazione istanze RoutingList
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class RoutingListFactory
{
    /**
     * Generazione istanza lista di mappature di instradamento
     *
     * @param array $nameSpaces Elenco di namespace in cui sono posizionate sotto-classi ControllerInterface
     *
     * @return RoutingListInterface
     */
    public static function create(array $nameSpaces = []): RoutingListInterface
    {
        $cache = Settings::getCache();
        if (is_null($cache)) {
            return self::makeRoutingList($nameSpaces);
        }
        $reference = md5(json_encode($nameSpaces));
        $routingList = $cache->read($reference);
        if (is_null($routingList)) {
            $routingList = self::makeRoutingList($nameSpaces);
            $cache->write($reference, serialize($routingList));
            return $routingList;
        }
        return unserialize($routingList);
    }

    /**
     * Costruzione istanza RoutingListInterface da elenco namespace
     *
     * @param array $nameSpaces Elenco di namespace in cui sono posizionate sotto-classi ControllerInterface
     *
     * @return RoutingListInterface
     */
    private static function makeRoutingList(array $nameSpaces = []): RoutingListInterface
    {
        $list = new RoutingList();
        foreach ($nameSpaces as $nameSpace) {
            $classes = ClassFinder::getClassesInNamespace($nameSpace, ClassFinder::RECURSIVE_MODE);
            foreach ($classes as $className) {
                $interfaces = class_implements($className);
                if (!in_array('Mikro\Controller\ControllerInterface', $interfaces)) {
                    continue;
                }
                $list->addItem(RoutingListItemFactory::create($className));
            }
        }
        return $list;
    }
}
