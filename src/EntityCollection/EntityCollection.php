<?php

/**
 * EntityCollection.php
 * Mikro\EntityCollection\EntityCollection
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\EntityCollection;

use Mikro\EntityCollection\EntityCollectionInterface;
use Mikro\Entity\EntityInterface;

/**
 * Implementazione concreta lista di entità generica
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class EntityCollection implements EntityCollectionInterface
{
    /**
     * Numero di pagina
     *
     * @var int $page Numero di pagina
     */
    private int $page = 1;

    /**
     * Numero di risultati per pagina
     *
     * @var int $limit Numero di risultati per pagina
     */
    private int $limit = DEFAULT_PAGINATION;

    /**
     * Numero di pagine
     *
     * @var int $pages Numero dipaginea
     */
    private int $pages = 1;

    /**
     * Numero di risultati totali disponibili
     *
     * @var int $total Numero di risultati totali disponibili
     */
    private int $total = 0;

    /**
     * Collezione di entità
     *
     * @var array $items Collezione di entità
     */
    private array $items = [];

    /**
     * Costruttore
     *
     * @param int $page Numero di pagina
     * @param ?int $limit Numero di risultati per pagina
     * @param int $pages Numero dipaginea
     * @param int $total Numero di risultati totali disponibili
     * @param EntityInterface ...$items Collezione di entità
     */
    public function __construct(
        ?int $page,
        ?int $limit,
        ?int $pages,
        ?int $total,
        EntityInterface ...$items
    ) {
        $this->page = is_null($page) ? 1 : $page;
        $this->limit = is_null($limit) ? DEFAULT_PAGINATION : $limit;
        $this->pages = is_null($pages) ? 1 : $pages;
        $this->total = is_null($total) ? 0 : $total;
        $this->items = $items;
    }

    /**
     * Recupero numero pagina corrente
     *
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * Recupero numero di risultati per pagina
     *
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * Recupero numero di pagine totali
     *
     * @return int
     */
    public function getPages(): int
    {
        return $this->pages;
    }

    /**
     * Recupero numero di risultati totale
     *
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * Recupero collezione di entità
     *
     * @return EntityInterface[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
