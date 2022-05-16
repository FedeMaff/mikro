<?php

/**
 * ObjectHttpResponse.php
 * Mikro\Response\ObjectHttpResponse
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

/**
 * Implementazione concreta risposta HTTP di un Oggetto generico
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class ObjectHttpResponse extends FormattableHttpResponseAbstract
{
    /**
     * Istanza Oggetto
     *
     * @var ?object $object Istanza oggetto generico
     */
    private ?object $object = null;

    /**
     * Costruttore
     *
     * @param object $object Istanza oggetto generico
     * @param int $statusCode Codice stato http
     * @param FormatterInterface $formatter Istanza formattatore
     */
    public function __construct(object $object, int $statusCode, FormatterInterface $formatter)
    {
        $this->object = $object;
        parent::__construct($statusCode, $formatter);
    }

    /**
     * Recupero contenuto response
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->formatter->objectToString($this->object);
    }
}
