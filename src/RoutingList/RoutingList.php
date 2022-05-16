<?php

/**
 * RoutingList.php
 * Mikro\RoutingList\RoutingList
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\RoutingList;

use Mikro\RoutingList\RoutingListInterface;
use Mikro\RoutingList\RoutingListItemInterface;
use Mikro\ControllerKey\HttpKey;
use Mikro\ControllerKey\AmqpKey;
use Mikro\ControllerKey\CliKey;

/**
 * Implementazione concreta lista di mappature di instradamento
 * Rappresenta una collezione di mappature RoutingListItem.
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class RoutingList implements RoutingListInterface
{
    /**
     * Elenco di mappature di instradamento
     *
     * @var array $items Elenco mappature instradamento
     */
    private array $items = [];

    /**
     * Inserimento mappatura di instradamento in elenco
     *
     * @return void
     */
    public function addItem(RoutingListItemInterface $item): void
    {
        $this->items[] = $item;
    }

    /**
     * Recupero elenco mappature di instradamento
     *
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * Recupero elenco mappature di instradamento di tipo HTTP
     *
     * @return array
     */
    public function getHttpItems(): array
    {
        return array_filter($this->items, function ($item) {
            return $item->getKey() instanceof HttpKey;
        });
    }

    /**
     * Recupero elenco mappature di instradamento di tipo AMQP
     *
     * @return array
     */
    public function getAmqpItems(): array
    {
        return array_filter($this->items, function ($item) {
            return $item->getKey() instanceof AmqpKey;
        });
    }

    /**
     * Recupero elenco mappature di instradamento di tipo CLI
     *
     * @return array
     */
    public function getCliItems(): array
    {
        return array_filter($this->items, function ($item) {
            return $item->getKey() instanceof CliKey;
        });
    }
}
