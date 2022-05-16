<?php

/**
 * RoutingListItem.php
 * Mikro\RoutingList\RoutingListItem
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\RoutingList;

use Mikro\RoutingList\RoutingListItemInterface;
use Mikro\ControllerKey\ControllerKeyInterface;

/**
 * Implementazione concreta mappatura di instradamento
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class RoutingListItem implements RoutingListItemInterface
{
    /**
     * Nome classe
     *
     * @var string $className Nome classe
     */
    private string $className = '';

    /**
     * Controller Key ( Istanza chiave controller )
     *
     * @var ?ControllerKeyInterface $key Istanza Controller Key
     */
    private ?ControllerKeyInterface $key;

    /**
     * Costrutture
     *
     * @param string $className Nome istanza HttpControllerInterface
     * @param ControllerKeyInterface $key Istanza Controller Key
     */
    public function __construct(string $className, ControllerKeyInterface $key)
    {
        $this->className = $className;
        $this->key = $key;
    }

    /**
     * Recupero nome classe
     *
     * @return string
     */
    public function getClassName(): string
    {
        return $this->className;
    }

    /**
     * Recupero chiave controller
     *
     * @return ControllerKeyInterface
     */
    public function getKey(): ControllerKeyInterface
    {
        return $this->key;
    }
}
