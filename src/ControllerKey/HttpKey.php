<?php

/**
 * HttpKey.php
 * Mikro\ControllerKey\HttpKey
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\ControllerKey;

use Mikro\ControllerKey\HttpKeyInterface;

/**
 * Implementazione concreta chiave controller riservata a richieste HTTP
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class HttpKey implements HttpKeyInterface
{
    /**
     * Metodo
     *
     * @var string $method Metodo HTTP Request
     */
    private string $method = '';

    /**
     * Path
     *
     * @var string $path Percorso HTTP Request
     */
    private string $path = '';

    /**
     * Costrutture
     *
     * @param string $className Nome istanza HttpControllerInterface
     */
    public function __construct(string $className)
    {
        $this->method = $className::getMethod();
        $this->path = $className::getPath();
    }

    /**
     * Recupero metodo http
     *
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Recupero path
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }
}
