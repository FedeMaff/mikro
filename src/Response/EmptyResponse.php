<?php

/**
 * EmptyResponse.php
 * Mikro\Response\EmptyResponse
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Response;

use Mikro\Response\ResponseInterface;

/**
 * Implementazione concreta risposta vuota
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class EmptyResponse implements ResponseInterface
{
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
