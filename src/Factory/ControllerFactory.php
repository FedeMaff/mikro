<?php

/**
 * ControllerFactory.php
 * Mikro\Factory\ControllerFactory
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Factory;

use Mikro\Controller\ControllerInterface;
use Mikro\Request\RequestInterface;
use Mikro\Request\AmqpRequestInterface;
use Mikro\Request\CliRequestInterface;
use Mikro\Request\HttpRequestInterface;
use Mikro\Factory\RoutingListFactory;
use Mikro\Factory\RoutingManagerFactory;
use Mikro\Settings;
use Mikro\Exceptions\NotSetException;
use Mikro\Exceptions\NotFoundException;

/**
 * Factory di generazione istanze Controller
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class ControllerFactory
{
    /**
     * Generazione istanza controller
     *
     * @param RequestInterface $request Istanza richiesta
     *
     * @return ControllerInterface
     */
    public static function create(RequestInterface $request): ControllerInterface
    {
        $nameSpaces = Settings::getControllersNameSpaces();

        if (empty($nameSpaces)) {
            self::throwNotSetException();
        }

        $routingList = RoutingListFactory::create($nameSpaces);
        $routingManager = RoutingManagerFactory::create($routingList, $request);
        $controller = $routingManager->getController();

        if (is_null($controller)) {
            static::throwNotFoundException($request);
        }

        return $controller;
    }

    /**
     * Avvio eccezione NotSetException
     *
     * @return void
     */
    private static function throwNotSetException(): void
    {
        $message[] = 'La collezione di name space controller Settings.controllersNameSpaces';
        $message[] = 'non riporta alcun tipo di name space psr-4. Senza un elenco di percorsi';
        $message[] = 'non e\' possibile trovare un controller per la richiesta.';
        $message = implode(' ', $message);
        throw new NotSetException($message);
    }

    /**
     * Avvio eccezione NotFoundException
     *
     * @param RequestInterface $request Istanza richiesta
     *
     * @return void
     */
    private static function throwNotFoundException(RequestInterface $request): void
    {
        switch (true) {
            case ($request instanceof AmqpRequestInterface):
                $eventName = $request->getEventName();
                $message[] = 'Non e\' stato trovato nessun controller compatibile con l\'evento';
                $message[] = sprintf('amqp: %s', $eventName);
                $message = implode(' ', $message);
                break;
            case ($request instanceof HttpRequestInterface):
                $method = $request->getMethod();
                $path = $request->getPath();
                $message[] = 'Non e\' stato trovato nessun controller compatibile con la';
                $message[] = sprintf('richiesta http: %s %s', $method, $path);
                $message = implode(' ', $message);
                break;
            case ($request instanceof CliRequestInterface):
                $commandName = $request->getCommandName();
                $message[] = 'Non e\' stato trovato nessun controller compatibile con il comando';
                $message[] = sprintf('cli: %s', $commandName);
                $message = implode(' ', $message);
                break;
        }
        throw new NotFoundException($message);
    }
}
