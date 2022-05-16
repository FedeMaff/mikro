<?php

/**
 * RoutingManagerFactory.php
 * Mikro\Factory\RoutingManagerFactory
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Factory;

use Mikro\RoutingList\RoutingListInterface;
use Mikro\Request\RequestInterface;
use Mikro\RoutingManager\RoutingManagerInterface;
use Mikro\RoutingManager\AmqpRoutingManager;
use Mikro\RoutingManager\CliRoutingManager;
use Mikro\RoutingManager\HttpRoutingManager;

/**
 * Factory di generazione istanza gestore di instradamento
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class RoutingManagerFactory
{
    /**
     * Generazione istanza gestore di instradamento
     *
     * @param RoutingListInterface $routingList Istanza lista di mappature di instradamento
     * @param RequestInterface $request Istanza richiesta
     *
     * @return RoutingManagerInterface
     */
    public static function create(RoutingListInterface $routingList, RequestInterface $request): RoutingManagerInterface
    {
        switch (true) {
            case ($request instanceof \Mikro\Request\AmqpRequestInterface):
                return new AmqpRoutingManager($routingList, $request);
            break;
            case ($request instanceof \Mikro\Request\CliRequestInterface):
                return new CliRoutingManager($routingList, $request);
            break;
            case ($request instanceof \Mikro\Request\HttpRequestInterface):
                return new HttpRoutingManager($routingList, $request);
            break;
        }
    }
}
