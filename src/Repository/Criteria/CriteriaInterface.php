<?php

/**
 * CriteriaInterface.php
 * Mikro\Repository\Criteria\CriteriaInterface
 *
 * PHP version 7.4
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Repository\Criteria;

use Mikro\Repository\Criteria\FiltersInterface;
use Mikro\Repository\Criteria\SortingInterface;
use Mikro\Repository\Criteria\PaginationInterface;

/**
 * Interfaccia criteri di lettura repository
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
interface CriteriaInterface
{
    /**
     * Recupero istanza di filtri di lettura
     *
     * @return ?FiltersInterface
     */
    public function getFilters(): ?FiltersInterface;

    /**
     * Recupero elenco di istanze di ordinamento
     *
     * @return SortingInterface[]
     */
    public function getSortings(): array;

    /**
     * Recupero istanza di gestione paginazione
     *
     * @return ?PaginationInterface
     */
    public function getPagination(): ?PaginationInterface;

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
    public function getFields(): array;
}
