<?php

/**
 * Sorting.php
 * Mikro\Repository\Criteria\Sorting
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Repository\Criteria;

use Mikro\Repository\Criteria\SortingInterface;

/**
 * Implementazione concreta criterio di ordinamento
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class Sorting implements SortingInterface
{
    /**
     * Nome proprietà di ordinamento
     *
     * @var ?string $field Nome proprietà di ordinamento
     */
    private ?string $field = null;

    /**
     * Tipo ordinamento
     *
     * @var ?string $order Tipo ordinamento
     */
    private ?string $order = null;

    /**
     * Costruttore
     *
     * @var string $field Nome proprietà di ordinamento
     * @var ?string $order Tipo ordinamento
     *
     * @return void
     */
    public function __construct(string $field, ?string $order = null)
    {
        $this->field = $field;
        $this->order = in_array($order, [ORDER_ASC, ORDER_DESC]) ? $order : DEFAULT_ORDER;
    }

    /**
     * Recupero nome proprietà di ordinamento
     *
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * Recupero tipo ordinamento
     *
     * @return string
     */
    public function getOrder(): string
    {
        return $this->order;
    }
}
