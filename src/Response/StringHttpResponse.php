<?php

/**
 * StringHttpResponse.php
 * Mikro\Response\StringHttpResponse
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Response;

use Mikro\Response\HttpResponseAbstract;
use Mikro\Tools\OutputDecorator;

/**
 * Implementazione concreta risposta HTTP formato stringa
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class StringHttpResponse extends HttpResponseAbstract
{
    /**
     * Stringa di testo
     *
     * @var string $string Stringa di testo
     */
    private string $string = '';

    /**
     * Costruttore
     *
     * @param string $string Contenuto testuale di risposta
     * @param int $statusCode Codice stato http
     */
    public function __construct(string $string, int $statusCode)
    {
        $this->string = $string;
        parent::__construct($statusCode);
    }

    /**
     * Recupero contenuto response
     *
     * @return string
     */
    public function __toString(): string
    {
        return OutputDecorator::decorate($this->string);
    }

    /**
     * Assegnazione valori Headers di default
     * Metodo dedicato alla definizione degli headers di risposta.
     * Questi valori verranno direttamnete implementati nelle estensioni
     * concrete della classe in oggetto.
     *
     * @return void
     */
    protected function setHeaders(): void
    {
        parent::setHeaders();
        $this->headers['Content-Type'] = 'text/plain; charset=utf-8';
    }
}
