<?php

/**
 * CliRoutingManager.php
 * Mikro\RoutingManager\CliRoutingManager
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\RoutingManager;

use Mikro\RoutingManager\RoutingManagerAbstract;
use Mikro\Controller\ControllerInterface;
use Mikro\RoutingList\RoutingListItemInterface;

/**
 * Implementazione concreta gestore di instradamento CLI
 * Quesato componente architetturale eseguira in modo concreto il match tra
 * la richiesta e le chiavi di instradamento mappate in una RoutingList.
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class CliRoutingManager extends RoutingManagerAbstract
{
    /**
     * Recupero elenco RoutingListItem
     * Questo metodo restituirà un elenco di RoutingListItem specifico
     * utilizzando la RoutingList di istanza potrà eseguire uno dei metodi
     * seguenti:
     *
     * - routingList->getHttpItems();
     * - routingList->getAmqpItems();
     * - routingList->getCliItems();
     *
     * @return RoutingListItem[]
     */
    protected function getRoutingListItems(): array
    {
        return $this->routingList->getCliItems();
    }

    /**
     * Verifica match tra richiesta e RoutingListItem
     *
     * @param RoutingListItemInterface $item Istanza mappature di instradamento
     *
     * @return bool
     */
    protected function matchesRequest(RoutingListItemInterface $item): bool
    {
        $itemCommandName = $item->getKey()->getCommandName();
        $reqCommandName = $this->request->getCommandName();
        return $itemCommandName == $reqCommandName;
    }
}
