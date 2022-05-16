<?php

/**
 * Filters.php
 * Mikro\Repository\Criteria\Filters
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Repository\Criteria;

use Mikro\Repository\Criteria\FiltersInterface;
use Mikro\Repository\Criteria\Filter\FilterInterface;
use Mikro\Repository\Criteria\FiltersGroup\FiltersGroupInterface;

/**
 * Implementazione concreta criteri di filtro
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class Filters implements FiltersInterface
{
    /**
     * Elenco filtri
     *
     * @var FilterInterface[] $filters Elenco filtri
     */
    private array $filters = [];

    /**
     * Elenco grouppi di filtri
     *
     * @var FiltersGroupInterface[] $groups Elenco grouppi di filtri
     */
    private array $groups = [];

    /**
     * Costruttore
     *
     * @param FilterInterface[] $filters Elenco filtri
     * @param FiltersGroupInterface[] $groups Elenco grouppi di filtri
     *
     * @return void
     */
    public function __construct(array $filters = [], array $groups = [])
    {
        $this->filters = $filters;
        $this->groups = $groups;
    }

    /**
     * Inserimento filtro in elenco filtri
     *
     * @param FilterInterface $filter Istanza condizione
     *
     * @return void
     */
    public function addFilter(FilterInterface $filter): void
    {
        $this->filters[] = $filter;
    }

    /**
     * Inserimento grouppo di filtri nell' elenco grouppi di filtri
     *
     * @param FiltersGroupInterface $group Istanza grouppo filtri
     *
     * @return void
     */
    public function addFiltersGroup(FiltersGroupInterface $group): void
    {
        $this->groups[] = $group;
    }

    /**
     * Recupero elenco filtri
     *
     * @return FilterInterface[]
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    /**
     * Recupero gruppi di filtri
     *
     * @return FiltersGroupInterface[]
     */
    public function getFiltersGroups(): array
    {
        return $this->groups;
    }
}
