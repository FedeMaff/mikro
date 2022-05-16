<?php

/**
 * RoutingManagerAbstract.php
 * Mikro\RoutingManager\RoutingManagerAbstract
 *
 * PHP version 7.4
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\RoutingManager;

use Mikro\RoutingList\RoutingListInterface;
use Mikro\RoutingList\RoutingListItemInterface;
use Mikro\Request\RequestInterface;
use Mikro\Controller\ControllerInterface;
use Mikro\RoutingManager\RoutingManagerInterface;

/**
 * Implementazione astratta gestore di instradamento
 * Quesato componente architetturale eseguira in modo concreto il match tra
 * la richiesta e le chiavi di instradamento mappate in una RoutingList.
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
abstract class RoutingManagerAbstract implements RoutingManagerInterface
{
    /**
     * Istanza lista di mappature di instradamento RoutingList
     *
     * @var ?RoutingListInterface $routingList Istanza RoutingListInterface
     */
    protected ?RoutingListInterface $routingList = null;

    /**
     * Istanza richiesta
     *
     * @var ?RequestInterface $request Istanza RequestInterface
     */
    protected ?RequestInterface $request = null;

    /**
     * Costrutture
     *
     * @param RoutingListInterface $routingList Istanza RoutingList
     * @param RequestInterface $request Istanza RequestInterface
     */
    public function __construct(RoutingListInterface $routingList, RequestInterface $request)
    {
        $this->routingList = $routingList;
        $this->request = $request;
    }

    /**
     * Recupero istanza Controller
     *
     * @return ?ControllerInterface
     */
    public function getController(): ?ControllerInterface
    {
        foreach ($this->getRoutingListItems() as $item) {
            if (!$this->matchesRequest($item)) {
                continue;
            }
            return $this->getControllerByClassName($item->getClassName());
        }
        return null;
    }

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
        return [];
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
        return true;
    }

    /**
     * Creazione istanza controller dato nome classe
     *
     * @param string $className Nome classe ControllerInterface
     *
     * @return ControllerInterface
     */
    protected function getControllerByClassName(string $className): ControllerInterface
    {
        $controller = new $className();
        $controller->setRequest($this->request);
        return $controller;
    }
}
