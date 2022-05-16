<?php

/**
 * FiltersInterface.php
 * Mikro\Repository\Criteria\FiltersInterface
 *
 * PHP version 7.4
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Repository\Criteria;

use Mikro\Repository\Criteria\Filter\FilterInterface;
use Mikro\Repository\Criteria\FiltersGroup\FiltersGroupInterface;

/**
 * Interfaccia criteri di filtro
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
interface FiltersInterface
{
    /**
     * Inserimento filtro in elenco filtri
     *
     * @param FilterInterface $filter Istanza condizione
     *
     * @return void
     */
    public function addFilter(FilterInterface $filter): void;

    /**
     * Inserimento grouppo di filtri nell' elenco grouppi di filtri
     *
     * @param FiltersGroupInterface $group Istanza grouppo filtri
     *
     * @return void
     */
    public function addFiltersGroup(FiltersGroupInterface $group): void;

    /**
     * Recupero elenco filtri
     *
     * @return FilterInterface[]
     */
    public function getFilters(): array;

    /**
     * Recupero gruppi di filtri
     *
     * @return FiltersGroupInterface[]
     */
    public function getFiltersGroups(): array;
}
