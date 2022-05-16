<?php

/**
 * HttpRequest.php
 * Mikro\Adapter\Request\Swoole\HttpRequest
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Adapter\Request\Swoole;

use Mikro\Request\HttpRequestInterface;
use Swoole\Http\Request as SwooleHttpRequest;

/**
 * Implementazione concreta richiesta HTTP Open Swoole
 * Link open swoole: https://openswoole.com
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class HttpRequest implements HttpRequestInterface
{
    /**
     * Richiesta HTTP Swoole
     *
     * @var ?SwooleHttpRequest $request Richiesta Swoole
     */
    private ?SwooleHttpRequest $request = null;

    /**
     * Costruttore
     *
     * @var SwooleHttpRequest $requet Richiesta in ingresso
     */
    public function __construct(SwooleHttpRequest $request)
    {
        $this->request = $request;
    }

    /**
     * Recupero parametri di richiesta
     *
     * @return array
     */
    public function getData(): array
    {
        $data = null;
        switch ($this->request->getMethod()) {
            case 'GET':
                $data = $this->request->get;
                break;
            case 'POST':
                $data = $this->request->post;
                break;
            case 'PUT':
            case 'PATCH':
            case 'DELETE':
                $data = $this->request->post;
                $string = $this->request->getContent();
                $json = json_decode($string, true);
                $data = json_last_error() === JSON_ERROR_NONE ? $json : $data;
                break;
        }
        return !is_array($data) ? [] : $data;
    }

    /**
     * Recupero metodo HTTP
     *
     * @return string
     */
    public function getMethod(): string
    {
        return $this->request->getMethod();
    }

    /**
     * Recupero percorso URL
     *
     * @return string
     */
    public function getPath(): string
    {
        return rtrim($this->request->server['request_uri'], '/');
    }

    /**
     * Recupero parametri derivanti da Header di richiesta
     *
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->request->header;
    }

    /**
     * Recupero elenco file multipart
     *
     * @return array
     */
    public function getFiles(): array
    {
        return $this->request->files;
    }

    /**
     * Recupero formato di output accettato
     * Qual'ora non vi sia un formato gestito da mkisoasd verrà
     * restituito il formato json.
     *
     * @return string
     */
    public function getOutputFormat(): string
    {
        return TYPE_JSON;
    }
}
