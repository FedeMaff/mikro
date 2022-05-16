<?php

/**
 * PaginationInterface.php
 * Mikro\Repository\Criteria\PaginationInterface
 *
 * PHP version 7.4
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Repository\Criteria;

/**
 * Interfaccia criterio di paginazione
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
interface PaginationInterface
{
    /**
     * Recupero numero di pagina
     *
     * @return int
     */
    public function getPage(): int;

    /**
     * Recupero numero di risultati per pagina
     *
     * @return int
     */
    public function getLimit(): int;
}
