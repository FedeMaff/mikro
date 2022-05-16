<?php

/**
 * SortingInterface.php
 * Mikro\Repository\Criteria\SortingInterface
 *
 * PHP version 7.4
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Repository\Criteria;

/**
 * Interfaccia criterio di ordinamento
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
interface SortingInterface
{
    /**
     * Recupero nome proprietà di ordinamento
     *
     * @return string
     */
    public function getField(): string;

    /**
     * Recupero tipo ordinamento
     *
     * @return string
     */
    public function getOrder(): string;
}
