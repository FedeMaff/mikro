<?php

/**
 * FormatterFactory.php
 * Mikro\Factory\FormatterFactory
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Factory;

use Mikro\Response\Formatter\FormatterInterface;
use Mikro\Response\Formatter\JsonFormatter;

/**
 * Factory di generazione istanze Formattatore di risposta ( Formatter )
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class FormatterFactory
{
    /**
     * Generazione istanza FormatterInterface
     *
     * @param string $type Tipo formato
     *
     * @return FormatterInterface
     */
    public static function create(string $type): FormatterInterface
    {
        return new JsonFormatter();
    }
}
