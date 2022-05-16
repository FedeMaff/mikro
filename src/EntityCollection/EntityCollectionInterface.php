<?php

/**
 * EntityCollectionInterface.php
 * Mikro\EntityCollection\EntityCollectionInterface
 *
 * PHP version 7.4
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\EntityCollection;

/**
 * Interfaccia generica lista di entità
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
interface EntityCollectionInterface
{
    /**
     * Recupero numero pagina corrente
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

    /**
     * Recupero numero di pagine totali
     *
     * @return int
     */
    public function getPages(): int;

    /**
     * Recupero numero di risultati totale
     *
     * @return int
     */
    public function getTotal(): int;

    /**
     * Recupero collezione di entità
     *
     * @return EntityInterface[]
     */
    public function getItems(): array;
}
