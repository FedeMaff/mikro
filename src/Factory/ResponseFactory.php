<?php

/**
 * ResponseFactory.php
 * Mikro\Factory\ResponseFactory
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Factory;

use Mikro\Response\Formatter\FormatterInterface;
use Mikro\Response\ResponseInterface;
use Mikro\Response\EmptyResponse;
use Mikro\Response\EntityResponse;
use Mikro\Response\EntityCollectionResponse;
use Mikro\Response\ExceptionResponse;
use Mikro\Response\FileResponse;
use Mikro\Response\ObjectResponse;
use Mikro\Response\StringResponse;
use Mikro\Entity\EntityInterface;
use Mikro\EntityCollection\EntityCollectionInterface;
use Mikro\File\FileInterface;
use Exception;
use Mikro\Exceptions\NotSetException;
use Mikro\Exceptions\SwitchCaseNotFoundException;

/**
 * Factory di generazione istanza di risposta generica ( Response )
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class ResponseFactory
{
    /**
     * Generazione istanza ResponseInterface
     *
     * @param any $content Contenuto della risposta
     * @param ?FormatterInterface $formatter Istanza formattatore output
     *
     * @return ResponseInterface
     */
    public static function create($content, ?FormatterInterface $formatter = null): ResponseInterface
    {
        switch (gettype($content)) {
            case 'NULL':
                return new EmptyResponse();
            break;
            case 'string':
                return new StringResponse($content);
            break;
            case 'object':
                if ($content instanceof FileInterface) {
                    return new FileResponse($content->getPath());
                }

                if (is_null($formatter)) {
                    static::throwNotSetException();
                }

                switch (true) {
                    case $content instanceof EntityInterface:
                        return new EntityResponse($content, $formatter);
                    break;

                    case $content instanceof EntityCollectionInterface:
                        return new EntityCollectionResponse($content, $formatter);
                    break;

                    case $content instanceof Exception:
                        return new ExceptionResponse($content, $formatter);
                    break;

                    default:
                        return new ObjectResponse($content, $formatter);
                    break;
                }
                break;
        }

        static::throwSwitchCaseNotFoundException($content);
    }

    /**
     * Avvio eccezione NotSetException
     *
     * @return void
     */
    private static function throwNotSetException(): void
    {
        $message[] = 'Nel tentativo di erogare la riposta generica di un istanza di tipo oggetto';
        $message[] = 'non è stato possibile assegnare il formattatore.';
        $message[] = 'Il controller che ha avviato il processo di risposta non ha trasmesso';
        $message[] = 'un elemento Formatter';
        $message = implode(' ', $message);
        throw new NotSetException($message);
    }

    /**
     * Avvio eccezione SwitchCaseNotFound
     *
     * @param any $content Contenuto di risposta
     *
     * @return void
     */
    private static function throwSwitchCaseNotFoundException($content): void
    {
        $message[] = 'Non è stato possibile selezionare un oggetto di risposta generico';
        $message[] = 'in quanto il tipo di contenuto "%s" non prevede un oggetto';
        $message[] = 'di riferimento. I tipi di contenuto per cui è stato implementato';
        $message[] = 'un oggetto di risposta generico specifico sono i seguenti: %s';
        $message = sprintf(implode(' ', $message), gettype($content), implode(', ', ['NULL', 'string', 'object']));
        throw new SwitchCaseNotFoundException($message);
    }
}
