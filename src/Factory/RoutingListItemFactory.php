<?php

/**
 * RoutingListItemFactory.php
 * Mikro\Factory\RoutingListItemFactory
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Factory;

use Mikro\RoutingList\RoutingListItemInterface;
use Mikro\RoutingList\RoutingListItem;
use Mikro\Factory\ControllerKeyFactory;

/**
 * Factory di generazione istanze RoutingListItem
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class RoutingListItemFactory
{
    /**
     * Generazione mappatura di instradamento
     *
     * @param string $className Nome istanza ControllerInterface
     *
     * @return RoutingListItemInterface
     */
    public static function create(string $className): RoutingListItemInterface
    {
        $key = ControllerKeyFactory::create($className);
        return new RoutingListItem($className, $key);
    }
}
