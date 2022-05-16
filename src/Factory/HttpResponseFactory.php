<?php

/**
 * HttpResponseFactory.php
 * Mikro\Factory\HttpResponseFactory
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Factory;

use Mikro\Response\Formatter\FormatterInterface;
use Mikro\Response\HttpResponseInterface;
use Mikro\Response\EmptyHttpResponse;
use Mikro\Response\EntityHttpResponse;
use Mikro\Response\EntityCollectionHttpResponse;
use Mikro\Response\ExceptionHttpResponse;
use Mikro\Response\FileHttpResponse;
use Mikro\Response\ObjectHttpResponse;
use Mikro\Response\StringHttpResponse;
use Mikro\Entity\EntityInterface;
use Mikro\EntityCollection\EntityCollectionInterface;
use Mikro\File\FileInterface;
use Exception;
use Mikro\Exceptions\NotSetException;
use Mikro\Exceptions\SwitchCaseNotFoundException;

/**
 * Factory di generazione istanza di risposta http ( HttpResponse )
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class HttpResponseFactory
{
    /**
     * Generazione istanza HttpResponseInterface
     *
     * @param any $content Contenuto della risposta
     * @param int $statusCode Codice di stato http risposta
     * @param ?FormatterInterface $formatter Istanza formattatore output
     *
     * @return HttpResponseInterface
     */
    public static function create(
        $content,
        int $statusCode,
        ?FormatterInterface $formatter = null
    ): HttpResponseInterface {
        switch (gettype($content)) {
            case 'NULL':
                return new EmptyHttpResponse($statusCode);
            break;
            case 'string':
                return new StringHttpResponse($content, $statusCode);
            break;
            case 'object':
                if ($content instanceof FileInterface) {
                    return new FileHttpResponse($content->getPath());
                }

                if (is_null($formatter)) {
                    static::throwNotSetException();
                }

                switch (true) {
                    case $content instanceof EntityInterface:
                        return new EntityHttpResponse($content, $statusCode, $formatter);
                    break;

                    case $content instanceof EntityCollectionInterface:
                        return new EntityCollectionHttpResponse($content, $statusCode, $formatter);
                    break;

                    case $content instanceof Exception:
                        return new ExceptionHttpResponse($content, $formatter);
                    break;

                    default:
                        return new ObjectHttpResponse($content, $statusCode, $formatter);
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
        $message[] = 'Nel tentativo di erogare la riposta http di un istanza di tipo oggetto';
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
        $message[] = 'Non è stato possibile selezionare un oggetto di risposta http';
        $message[] = 'in quanto il tipo di contenuto "%s" non prevede un oggetto';
        $message[] = 'di riferimento. I tipi di contenuto per cui è stato implementato';
        $message[] = 'un oggetto di risposta http specifico sono i seguenti: %s';
        $message = sprintf(implode(' ', $message), gettype($content), implode(', ', ['NULL', 'string', 'object']));
        throw new SwitchCaseNotFoundException($message);
    }
}
