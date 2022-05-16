<?php

/**
 * Pagination.php
 * Mikro\Repository\Criteria\Pagination
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Repository\Criteria;

use Mikro\Repository\Criteria\PaginationInterface;

/**
 * Implementazione concreta criterio di paginazione
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class Pagination implements PaginationInterface
{
    /**
     * Numero di pagina
     *
     * @var ?int $page Numero di pagina
     */
    private ?int $page = null;

    /**
     * Numero di risultati per pagina
     *
     * @var ?int $limit Numero di risultati per pagina
     */
    private ?int $limit = null;

    /**
     * Costruttore
     *
     * @param int $page Numero di pagina
     * @param int $limit Numero di risultati per pagina
     *
     * @return void
     */
    public function __construct(int $page = 1, int $limit = DEFAULT_PAGINATION)
    {
        $this->page = abs($page);
        $this->limit = abs($limit);
    }

    /**
     * Recupero numero di pagina
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
}
