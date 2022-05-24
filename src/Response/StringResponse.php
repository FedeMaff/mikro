<?php

/**
 * StringResponse.php
 * Mikro\Response\StringResponse
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Response;

use Mikro\Response\ResponseInterface;
use Mikro\Tools\OutputDecorator;

/**
 * Implementazione concreta risposta formato stringa
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class StringResponse implements ResponseInterface
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
     */
    public function __construct(string $string)
    {
        $this->string = $string;
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
}
