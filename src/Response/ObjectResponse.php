<?php

/**
 * ObjectResponse.php
 * Mikro\Response\ObjectResponse
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

/**
 * Implementazione concreta risposta formato Oggetto generico
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class ObjectResponse extends FormattableResponseAbstract
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
     * @param FormatterInterface $formatter Istanza formattatore
     */
    public function __construct(object $object, FormatterInterface $formatter)
    {
        $this->object = $object;
        parent::__construct($formatter);
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
