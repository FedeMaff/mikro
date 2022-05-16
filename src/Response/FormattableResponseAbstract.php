<?php

/**
 * ResponseInterface.php
 * Mikro\Response\ResponseInterface
 *
 * PHP version 7.4
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Response;

use Mikro\Response\ResponseInterface;
use Mikro\Response\Formatter\FormatterInterface;

/**
 * Interfaccia generica oggetto di risposta
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
abstract class FormattableResponseAbstract implements ResponseInterface
{
    /**
     * Istanza formattatore
     *
     * @var ?FormatterInterface $formatter Istanza formattatore
     */
    protected ?FormatterInterface $formatter = null;

    /**
     * Costrutture
     *
     * @param FormatterInterface $formatter Istanza formattatore
     *
     * @return void
     */
    public function __construct(FormatterInterface $formatter)
    {
        $this->formatter = $formatter;
    }

    /**
     * Recupero contenuto response
     *
     * @return string
     */
    public function __toString(): string
    {
        return '';
    }
}
