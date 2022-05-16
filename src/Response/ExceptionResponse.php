<?php

/**
 * ExceptionResponse.php
 * Mikro\Response\ExceptionResponse
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Response;

use Mikro\Response\FormattableResponseAbstract;
use Mikro\Response\Formatter\FormatterInterface;
use Exception;

/**
 * Implementazione concreta risposta formato Eccezione
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class ExceptionResponse extends FormattableResponseAbstract
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
        parent::__construct($formatter);
    }

    /**
     * Recupero contenuto response
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->formatter->exceptionToString($this->exception);
    }
}
