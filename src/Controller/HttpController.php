<?php

/**
 * HttpController.php
 * Mikro\Controller\HttpController
 *
 * PHP version 7.4
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Controller;

use Mikro\Controller\ControllerAbstract;
use Mikro\Controller\HttpControllerInterface;
use Mikro\Response\ResponseInterface;
use Mikro\Factory\FormatterFactory;
use Mikro\Factory\HttpResponseFactory;

/**
 * Implementazione astratta controller HTTP
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
abstract class HttpController extends ControllerAbstract implements HttpControllerInterface
{
    /**
     * Metodo di riferimento
     *
     * @var string $method Metodo di riferimento
     */
    protected static string $method = '';

    /**
     * Percorso di riferimento
     *
     * @var string $path Percorso di riferimento
     */
    protected static string $path = '';

    /**
     * Recupero metodo
     *
     * @return string
     */
    public static function getMethod(): string
    {
        return static::$method;
    }

    /**
     * Recupero percorso di riferimento
     *
     * @return string
     */
    public static function getPath(): string
    {
        return static::$path;
    }

    /**
     * Esecuzione controller e logiche di business implementate
     *
     * @return ?ResponseInterface
     */
    public function run(): ?ResponseInterface
    {
        return null;
    }

    /**
     * Trasformazione valore in response
     *
     * @param any $content Contenuto di risposta
     * @param ?int $statusCode Codice di risposta http
     *
     * @return ResponseInterface
     */
    protected function toResponse($content, ?int $statusCode = null): ResponseInterface
    {
        $statusCode = is_null($statusCode) ? ((static::$method == 'post') ? CREATED : OK) : $statusCode;
        $type = is_null($this->request) ?  TYPE_JSON : $this->request->getOutputFormat();
        $formatter = FormatterFactory::create($type);
        return HttpResponseFactory::create($content, $statusCode, $formatter);
    }
}
