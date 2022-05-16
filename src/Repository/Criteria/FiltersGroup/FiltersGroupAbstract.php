<?php

/**
 * FiltersGroupAbstract.php
 * Mikro\Repository\Criteria\FiltersGroup\FiltersGroupAbstract
 *
 * PHP version 7.4
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Repository\Criteria\FiltersGroup;

use Mikro\Repository\Criteria\FiltersGroup\FiltersGroupInterface;
use Mikro\Repository\Criteria\Filter\FilterInterface;

/**
 * Implementazione astratta gruppo di filtri
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
abstract class FiltersGroupAbstract implements FiltersGroupInterface
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
