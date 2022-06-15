<?php

/**
 * StringFormatterInterface.php
 * Mikro\Formatter\StringFormatterInterface
 *
 * PHP version 7.4
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Formatter;

use Mikro\Formatter\FormatterInterface;

/**
 * Interfaccia formattatore stringa
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
interface StringFormatterInterface extends FormatterInterface
{
    /**
     * Esecuzione formattazione stringa
     *
     * @param string $string Stringa oggetto di formattazione
     *
     * @return string
     */
    public function __invoke(string $string): string;
}
