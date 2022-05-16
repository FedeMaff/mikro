<?php

/**
 * Criteria.php
 * Mikro\Repository\Criteria\Criteria
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Repository\Criteria;

use Mikro\Repository\Criteria\CriteriaInterface;
use Mikro\Repository\Criteria\FiltersInterface;
use Mikro\Repository\Criteria\SortingInterface;
use Mikro\Repository\Criteria\PaginationInterface;
use Mikro\Repository\Criteria\Filters;

/**
 * Interfaccia criteri di lettura repository
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class Criteria implements CriteriaInterface
{
    /**
     * Istanza filtri di lettura
     *
     * @var ?FiltersInterface $filters Istanza filtri di lettura
     */
    private ?FiltersInterface $filters = null;

    /**
     * Istanza di gestione paginazione
     *
     * @var ?PaginationInterface $pagination Istanza di gestione paginazione
     */
    private ?PaginationInterface $pagination = null;

    /**
     * Elenco istanze di ordinamento
     *
     * @var SortingInterface[] $sortings Elenco istanze di ordinamento
     */
    private array $sortings = [];

    /**
     * Elenco di proprietà di ritorno
     *
     * @var string[] $fields Elenco di proprietà di ritorno
     */
    private array $fields = [];

    /**
     * Costruttore
     *
     * @param ?FiltersInterface $filters Istanza filtri di lettura
     * @param SortingInterface[] $sortings Elenco istanze di ordinamento
     * @param ?PaginationInterface $pagination Istanza di gestione paginazione
     * @param string[] $fields Elenco di proprietà di ritorno
     */
    public function __construct(
        ?FiltersInterface $filters = null,
        ?PaginationInterface $pagination = null,
        array $sortings = [],
        array $fields = []
    ) {
        $this->filters = is_null($filters) ? new Filters() : $filters;
        $this->pagination = $pagination;
        $this->sortings = $sortings;
        $this->fields = $fields;
    }

    /**
     * Recupero istanza di filtri di lettura
     *
     * @return ?FiltersInterface
     */
    public function getFilters(): ?FiltersInterface
    {
        return $this->filters;
    }

    /**
     * Recupero istanza di gestione paginazione
     *
     * @return ?PaginationInterface
     */
    public function getPagination(): ?PaginationInterface
    {
        return $this->pagination;
    }

    /**
     * Recupero elenco di istanze di ordinamento
     *
     * @return SortingInterface[]
     */
    public function getSortings(): array
    {
        return $this->sortings;
    }

    /**
     * Recupero elenco di proprietà di ritorno
     *
     * Per una corretta "apertura" alle più performanti e sicure
     * linee guida in ambito API, è buna norma prevedere che il
     * client possa specificare quali field siano richiesti nell'output
     * di ricerca / estrazione. L'interfaccia fields descrive
     * la struttura di un componente il cui compito è quello di
     * descrivere quali proprietà dell'entità di riferimento siano
     * di interesse del consumatore.
     *
     * @return string[]
     */
    public function getFields(): array
    {
        return $this->fields;
    }
}
