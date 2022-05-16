<?php

/**
 * HttpRoutingManager.php
 * Mikro\RoutingManager\HttpRoutingManager
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
use Mikro\ControllerKey\HttpKeyInterface;
use Mikro\RoutingList\RoutingListItemInterface;

/**
 * Implementazione concreta gestore di instradamento HTTP
 * Quesato componente architetturale eseguira in modo concreto il match tra
 * la richiesta e le chiavi di instradamento mappate in una RoutingList.
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class HttpRoutingManager extends RoutingManagerAbstract
{
    /**
     * Variabili derivanti dal path della richiesta
     *
     * @var array $pathVariables Collezion di variabili derivanti dal path di richiesta
     */
    private array $pathVariables = [];

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
            $this->parsePathVariables($item->getKey());
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
        return $this->routingList->getHttpItems();
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
        $key = $item->getKey();
        return $this->matchesRequestMethod($key) && $this->matchesRequestPath($key);
    }

    /**
     * Estrazione e valorizzazione Variabili di percorso
     *
     * @param HttpKeyInterface $key Istanza HttpKey
     *
     * @return void
     */
    protected function parsePathVariables(HttpKeyInterface $key): void
    {
        $keyPath = $key->getPath();
        $keyPathPieces = explode('/', ltrim($keyPath));

        $reqPath = $this->request->getPath();
        $reqPathPieces = explode('/', ltrim($reqPath));

        foreach ($keyPathPieces as $key => $value) {
            // Recupero segnaposto dal path del controller
            \preg_match('/^\{([a-zA-Z]+):?(int|string)?\}$/', $value, $matches);
            $placeholderName = isset($matches[1]) ? $matches[1] : null;
            $placeholderType = isset($matches[2]) ? $matches[2] : 'int';
            if (null == $placeholderName) {
                continue;
            }

            // Estrazione valore placeholder da equivalente piece della richiesta
            $pattern = ($placeholderType == 'string') ? '/^[a-zA-Z0-9]+(?:-[a-zA-Z0-9]+)*$/' : '/^[1-9]+(?:[0-9]+)*$/';
            \preg_match($pattern, $reqPathPieces[$key], $matches);
            $this->pathVariables[$placeholderName] = $matches[0];
        }
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
        $class = new \ReflectionClass($className);
        $controller = $class->newInstanceArgs($this->pathVariables);
        $controller->setRequest($this->request);
        return $controller;
    }

    /**
     * Verifica match tra metodo di richiesta e metodo RoutingListItem.key
     *
     * @param HttpKeyInterface $key Istanza HttpKey
     *
     * @return bool
     */
    private function matchesRequestMethod(HttpKeyInterface $key): bool
    {
        $keyMethod = $key->getMethod();
        $reqMethod = $this->request->getMethod();
        return strtolower($keyMethod) == strtolower($reqMethod);
    }

    /**
     * Verifica match tra percorso di richiesta e percorso RoutingListItem.key
     *
     * @param HttpKeyInterface $key Istanza HttpKey
     *
     * @return bool
     */
    private function matchesRequestPath(HttpKeyInterface $key): bool
    {
        $keyPath = $key->getPath();
        $keyPathPieces = explode('/', ltrim($keyPath));

        $reqPath = $this->request->getPath();
        $reqPathPieces = explode('/', ltrim($reqPath));

        if (count($keyPathPieces) != count($reqPathPieces)) {
            return false;
        }

        foreach ($keyPathPieces as $key => &$value) {
            // Recupero segnaposto dal path del controller
            \preg_match('/^\{([a-zA-Z]+):?(int|string)?\}$/', $value, $matches);
            $placeholderName = isset($matches[1]) ? $matches[1] : null;
            $placeholderType = isset($matches[2]) ? $matches[2] : 'int';
            if (null == $placeholderName) {
                continue;
            }

            // Estrazione valore placeholder da equivalente piece della richiesta
            $pattern = ($placeholderType == 'string') ? '/^[a-zA-Z0-9]+(?:-[a-zA-Z0-9]+)*$/' : '/^[1-9]+(?:[0-9]+)*$/';
            \preg_match($pattern, $reqPathPieces[$key], $matches);
            $value = isset($matches[0]) && !is_null($matches[0]) ? $matches[0] : $value;
        }

        $keyPath = implode('/', $keyPathPieces);
        return $keyPath == $reqPath;
    }
}
