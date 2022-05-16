<?php

/**
 * RoutingListInterface.php
 * Mikro\RoutingList\RoutingListInterface
 *
 * PHP version 7.4
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\RoutingList;

use Mikro\RoutingList\RoutingListItemInterface;

/**
 * Interfaccia lista di mappature di instradamento
 * Rappresenta una collezione di mappature RoutingListItem.
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
interface RoutingListInterface
{
    /**
     * Inserimento mappatura di instradamento in elenco
     *
     * @return void
     */
    public function addItem(RoutingListItemInterface $item): void;

    /**
     * Recupero elenco mappature di instradamento
     *
     * @return array
     */
    public function getItems(): array;

    /**
     * Recupero elenco mappature di instradamento di tipo HTTP
     *
     * @return array
     */
    public function getHttpItems(): array;

    /**
     * Recupero elenco mappature di instradamento di tipo AMQP
     *
     * @return array
     */
    public function getAmqpItems(): array;

    /**
     * Recupero elenco mappature di instradamento di tipo CLI
     *
     * @return array
     */
    public function getCliItems(): array;
}
