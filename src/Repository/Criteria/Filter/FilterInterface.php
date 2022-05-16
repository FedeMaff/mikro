<?php

/**
 * FilterInterface.php
 * Mikro\Repository\Criteria\Filter\Filter\Filter\FilterInterface
 *
 * PHP version 7.4
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Repository\Criteria\Filter;

/**
 * Interfaccia filtro di lettura
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
interface FilterInterface
{
    /**
     * Recupero nome field di riferimento
     *
     * @return string
     */
    public function getField(): string;

    /**
     * Recupero operatore
     *
     * @return string
     */
    public function getOperator(): string;
}
