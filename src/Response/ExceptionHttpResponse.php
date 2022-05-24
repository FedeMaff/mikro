<?php

/**
 * ExceptionHttpResponse.php
 * Mikro\Response\ExceptionHttpResponse
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Response;

use Mikro\Response\FormattableHttpResponseAbstract;
use Mikro\Response\Formatter\FormatterInterface;
use Mikro\Tools\OutputDecorator;
use Exception;

/**
 * Implementazione concreta risposta HTTP di un' Eccezione
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class ExceptionHttpResponse extends FormattableHttpResponseAbstract
{
    /**
     * Istanza eccezione
     *
     * @var ?Exception $exception Istanza Exception
     */
    private ?Exception $exception = null;

    /**
     * Costruttore
     *
     * @param Exception $exception Istanza Exception
     * @param FormatterInterface $formatter Istanza formattatore
     */
    public function __construct(Exception $exception, FormatterInterface $formatter)
    {
        $this->exception = $exception;
        parent::__construct($exception->getCode(), $formatter);
    }

    /**
     * Recupero contenuto response
     *
     * @return string
     */
    public function __toString(): string
    {
        $string = $this->formatter->exceptionToString($this->exception);
        return OutputDecorator::decorate($string);
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
        $type = $this->formatter->getType() ==  TYPE_JSON ? 'json' : 'json';
        $this->headers['Content-Type'] = "application/problem+${type}; charset=utf-8";
    }
}
